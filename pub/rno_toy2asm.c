// DISASSEMBLER for TOY machine code
//
// :author:   Lukas Prokop
// :date:     12th of March 2011
// :course:   RO / RNO
// :license:  GPLv3
//
// :input:    a TOY file via stdin
// :output:   an ASM file via stdout
//
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>

#define BUFFER_SIZE 512

enum boolean_t {FALSE = 0, TRUE = 1};

typedef unsigned char Byte;
typedef short int TwoBytes;
typedef enum boolean_t boolean;

struct format1
{
  Byte d;
  Byte s;
  Byte t;
};
struct format2
{
  Byte d;
  TwoBytes imm;
};
typedef union args
{
  struct format1 format1;
  struct format2 format2;
} Args;

typedef struct line
{
  Byte pc;
  Byte cmd;
  Args args;
  unsigned int format;
} Line;

//-----------------------------------------------------------------------------
// A beautiful readStdin function using only realloc to alloc memory for
// a string. Returns pointer to new string or NULL.
char* readStdin()
{
  unsigned int size = 0;
  unsigned int pos = 0;
  char letter;
  char* content = NULL;

  while ((letter = getchar()) != EOF)
  {
    if (pos % BUFFER_SIZE == 0)
    {
      void* tmp = realloc(content, ++size * BUFFER_SIZE * sizeof(char));
      if (!tmp)
      {
        free(content);
        content = NULL;
        return NULL;
      }
      content = tmp;
      pos = 0;
    }
    content[(size - 1) * BUFFER_SIZE + pos++] = letter;
  }
  return content;
}

//-----------------------------------------------------------------------------
// Accepts a string and returns the number of *valid* machine code lines
unsigned long getNumberOfLines(char* content)
{
  unsigned long number = 0;
  char letter;
  int pos = 0;

  while ((letter = *content++) != '\0')
  {
    if (letter == '\n')
    {
      number++;
      pos = -1;
    } else {
      if (pos < 6)
        pos++;
    }
    if (pos == 2 && letter != ':')
      number--;
  }

  return number;
}

//-----------------------------------------------------------------------------
// Initializes or clears an Line struct
void initLine(Line* l)
{
  l->pc = 0x00;
  l->cmd = 0x00;
  l->format = 0x00;
  l->args.format1.d = 0x00;
  l->args.format1.s = 0x00;
  l->args.format1.t = 0x00;
  l->args.format2.d = 0x00;
  l->args.format2.imm = 0x00;
}

//-----------------------------------------------------------------------------
// Get an array of JMP addresses (PCs where labels have to be created), the
// length of this array and an PC to search for. Now return the index of the
// the searched PC in jmps. Has worst-case O(n).
int getJumpID(Byte* jmps, unsigned int length, Byte pc)
{
  unsigned int iter;
  for (iter=0; iter<length; iter++)
  {
    if (jmps[iter] == pc)
      return iter;
  }
  return -1;
}

//-----------------------------------------------------------------------------
// Get content of an TOY machine code file and parse it. Render valid lines in
// Line structs and store addresses of JMPs. Then write Labels and ASM
// statements to stdout. Return 0 on success, 1 on memory alloc error.
int parseFile(char* content)
{
  unsigned int number_of_lines;
  unsigned long number = 0;
  unsigned int jmp = 0;
  int jmp_id;
  char letter;
  int check_line = 0;
  int pos;
  unsigned long iter = 0;
  boolean tmp_flag;
  Line line;

  // calculate #(lines) for Line Array
  // the line validation is more loose than the actual Line data insertion
  number_of_lines = getNumberOfLines(content);
  Line* lines = calloc(number_of_lines, sizeof(Line));
  if (!lines)
    return 1;
  // save all jump statements. #(jmps) < #(lines)
  Byte* jmps = calloc(number_of_lines, sizeof(Byte));
  if (!jmps)
  {
    free(lines);
    return 1;
  }

  while ((letter = *content++) != '\0')
  {
    if (letter == '\n')
    {
      Line line; // temporary Line struct
      initLine(&line); // empty Line
      pos = -1; // position counter in line
      check_line = 0; // counter of valid values
    }
    char symbol[2];
    sprintf(symbol, "%c ", letter);

    switch (pos)
    {
      case 0: // PC part 1
        if (isxdigit(letter))
        {
          line.pc = strtol(symbol, NULL, 16) * 16;
          check_line++;
        }
        break;
      case 1: // PC part 2
        if (isxdigit(letter))
        {
          line.pc += strtol(symbol, NULL, 16);
          check_line++;
        }
        break;
      case 2:
        if (letter == ':')
          check_line++;
        break;
      case 3:
        if (letter == ' ')
          check_line++;
        break;
      case 4: // cmd
        if (isxdigit(letter))
        {
          long int l = strtol(symbol, NULL, 16);
          if ((7 <= l && l <= 9) || (0x0C <= l && l <= 0x0F))
          {
            line.format = 2;
          } else {
            line.format = 1;
          }
          line.cmd = l;
          check_line++;
        }
        break;
      case 5: // arg1
        if (isxdigit(letter))
        {
          if (line.format == 1)
            line.args.format1.d = strtol(symbol, NULL, 16);
          else
            line.args.format2.d = strtol(symbol, NULL, 16);
          if (line.cmd == 0x0E)
          {
            tmp_flag = FALSE;
            for (iter=0; iter<jmp; iter++)
              if (jmps[iter] == line.args.format2.d)
                tmp_flag = TRUE;
            if (!tmp_flag)
              jmps[jmp++] = line.args.format2.d;
          }
          check_line++;
        }
        break;
      case 6: // arg2
        if (isxdigit(letter))
        {
          if (line.format == 1)
            line.args.format1.s = strtol(symbol, NULL, 16);
          else
            line.args.format2.imm += strtol(symbol, NULL, 16) * 16;
          check_line++;
        }
        break;
      case 7: // arg3
        if (isxdigit(letter))
        {
          if (line.format == 1)
            line.args.format1.t = strtol(symbol, NULL, 16);
          else
            line.args.format2.imm += strtol(symbol, NULL, 16);
          check_line++;
        }
        // if (is JMP statement)
        if (line.cmd == 0x0C || line.cmd == 0x0D || line.cmd == 0x0F)
        {
          tmp_flag = FALSE;
          for (iter=0; iter<jmp; iter++)
            if (jmps[iter] == line.args.format2.imm)
              tmp_flag = TRUE;
          // then store this address in jmps array
          if (!tmp_flag)
            jmps[jmp++] = line.args.format2.imm;
        }
        // if (8 valid values were found) then store this line
        if (check_line == 8)
          lines[number++] = line;
        initLine(&line);
        break;
    }
    if (pos < 10)
      pos++;
  }

  for (pos=0; pos<number_of_lines; pos++)
  {
    Line item = lines[pos];

    // if (label has to be in current line) then print it
    unsigned long iter;
    tmp_flag = FALSE;
    for (iter=0; iter<number_of_lines; iter++)
    {
      if (jmps[iter] == item.pc)
      {
        printf("JMP%02ld   ", iter);
        tmp_flag = TRUE;
        // if must be satisfied only once. jmps has to be a set.
        // therefore: reduce O(n) to worst case scenario
        break;
      }
    }
    if (!tmp_flag)
      printf("        ");

    switch (item.cmd)
    {
      case 0x00:
        printf("HLT\n");
        printf("ERROR   HLT\n");
        break;
      case 0x01:
        printf("ADD R%X, R%X, R%X\n", item.args.format1.d,
            item.args.format1.s, item.args.format1.t);
        break;
      case 0x02:
        printf("SUB R%X, R%X, R%X\n", item.args.format1.d,
            item.args.format1.s, item.args.format1.t);
        break;
      case 0x03:
        printf("AND R%X, R%X, R%X\n", item.args.format1.d,
            item.args.format1.s, item.args.format1.t);
        break;
      case 0x04:
        printf("XOR R%X, R%X, R%X\n", item.args.format1.d,
            item.args.format1.s, item.args.format1.t);
        break;
      case 0x05:
        printf("SHL R%X, R%X, R%X\n", item.args.format1.d,
            item.args.format1.s, item.args.format1.t);
        break;
      case 0x06:
        printf("SHR R%X, R%X, R%X\n", item.args.format1.d,
            item.args.format1.s, item.args.format1.t);
        break;
      case 0x07:
        printf("LDA R%X, 0x%02X\n", item.args.format2.d,
            item.args.format2.imm);
        break;
      case 0x08:
        printf("LD R%X, 0x%02X\n", item.args.format2.d,
            item.args.format2.imm);
        break;
      case 0x09:
        printf("ST R%X, 0x%02X\n", item.args.format2.d,
            item.args.format2.imm);
        break;
      case 0x0A:
        printf("LDI R%X, R%X\n", item.args.format1.d,
            item.args.format1.t);
        break;
      case 0x0B:
        printf("STI R%X, R%X\n", item.args.format1.d,
            item.args.format1.t);
        break;
      case 0x0C:
        jmp_id = getJumpID(jmps, number_of_lines,
            item.args.format2.imm);
        if (jmp_id < 0)
          printf("BZ R%X, ERROR\n", item.args.format2.d);
        else
          printf("BZ R%X, JMP%02X\n", item.args.format2.d,
              jmp_id);
        break;
      case 0x0D:
        jmp_id = getJumpID(jmps, number_of_lines,
            item.args.format2.imm);
        if (jmp_id < 0)
          printf("BP R%X, ERROR\n", item.args.format2.d);
        else
          printf("BP R%X, JMP%02X\n", item.args.format2.d,
              jmp_id);
        break;
      case 0x0E:
        printf("JR R%X\n", item.args.format1.d);
        break;
      case 0x0F:
        jmp_id = getJumpID(jmps, number_of_lines,
            item.args.format2.imm);
        if (jmp_id < 0)
          printf("JL R%X, ERROR\n", item.args.format2.d);
        else
          printf("JL R%X, JMP%02X\n", item.args.format2.d,
              jmp_id);
        break;
    }

    if (item.cmd == 0x00)
      pos = number_of_lines;
  }

  free(lines);
  free(jmps);
  return 0;
}


int main()
{
  char* content;
  int status;

  // Read stdin
  content = readStdin();
  if (content == NULL)
    return 1;

  status = parseFile(content);
  if (status == 1)
    printf("Out of memory\n");

  //printf("%s\n", content);
  free(content);

  return 0;
}
