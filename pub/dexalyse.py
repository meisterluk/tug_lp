#!/usr/bin/env python

import sys
import os.path
import string
import itertools

INDENT = 18
_TMP_CACHE = 0

def streambyte_to_int(stream, length=4):
    """Reads bytes from stream with size length.
    length 0 means values is NULL-terminated.
    """
    values = []
    if length == 0:
        iter_algo = itertools.count()
    else:
        iter_algo = xrange(length)

    for byte_id in iter_algo:
        byte = ord(stream.read(1))
        values.append(byte)
        if length == 0 and byte == 0:
            break
    return values

def combine_to_int(values):
    """Combine several byte values to an integer"""
    multibyte_value = 0
    for byte_id, byte in enumerate(values):
        multibyte_value += 2**(4 * byte_id) * byte
    return multibyte_value

def convert(value):
    """Get a decimal value and return a tuple of that value in different
    numerical formats. (<str>hex, <str>binary, <str>ASCII, <int>int)
    """
    if value < 256 and value > 32 and chr(value) in string.printable:
        ascii_val = chr(value)
    else:
        ascii_val = ""

    return (hex(value), bin(value), ascii_val, value)

def read_uint(stream, indent=INDENT):
    """Read an unsigned integer from stream"""
    global _TMP_CACHE

    value = combine_to_int(streambyte_to_int(stream, 4))
    formats = list(convert(value))
    _TMP_CACHE = formats[3]

    output = str(formats[3]) + " (" + formats[0] + ", " + formats[1]
    if formats[2]:
        output += ', ascii:"' + formats[2] + '"'
    output += ")"

    return output

def read_char(stream, indent=INDENT):
    """Read a character from stream"""
    value = streambyte_to_int(stream, 1)
    formats = list(convert(value[0]))

    formats[0] = 'HEX:   ' + formats[0]
    formats[1] = 'BIN:   ' + formats[1]
    formats[2] = 'ASCII: ' + formats[2]
    formats[3] = 'INT:   ' + str(formats[3])

    return ('\n' + (' ' * indent)).join(formats)

def read_bool(stream, indent=INDENT):
    """Read a character from stream"""
    value = streambyte_to_int(stream, 1)[0]
    return str(bool(value)) + " [HEX: " + hex(value) + "]"

def read_string(stream, indent=INDENT):
    """Read a NULL-terminated string from stream"""
    values = streambyte_to_int(stream, 0)
    return '"' + ''.join(map(chr, values[:-1])) + '"\n' \
        + (' ' * indent) + 'HEX:     ' + (', '.join(map(hex, values)))

def dexalyse(filepath):
    fp = open(sys.argv[1], 'rb')

    try:
        print "DexAlyse -- analysing binary Dex files"
        print "=" * 38
        print
        print ".FILE ", os.path.basename(filepath)
        print

        print "Magic numbers    ", read_string(fp)

        print "Number Attacks   ", read_uint(fp)
        number_of_attacks = _TMP_CACHE
        print "Number Monsters  ", read_uint(fp)
        number_of_monsters = _TMP_CACHE

        print
        print ".NOTE Expecting %d Attacks and %d Monsters now" % \
            (number_of_attacks, number_of_monsters)

        print
        for attack_id in xrange(number_of_attacks):
            print ".ATTACK #%d" % attack_id
            print
            print "Length of Name   ", read_uint(fp)
            print "Name             ", read_string(fp)
            print "Type             ", read_uint(fp)
            print "Damage           ", read_uint(fp)
            print "Sleep Effect     ", read_bool(fp)
            print "Burn Effect      ", read_bool(fp)
            print "Poison Effect    ", read_bool(fp)
            print "Leech Effect     ", read_bool(fp)
            print

        for monster_id in xrange(number_of_monsters):
            print ".MONSTER #%d" % monster_id
            print
            print "Length of Name   ", read_uint(fp)
            print "Name             ", read_string(fp)
            print "Type             ", read_uint(fp)
            print "Health           ", read_uint(fp)
            print "Attack           ", read_uint(fp)
            print "Defense          ", read_uint(fp)
            print "Evolves at       ", read_uint(fp)
            print "Evolves to       ", read_uint(fp)
            print "Attack #1        ", read_uint(fp)
            print "Attack #2        ", read_uint(fp)
            print "Attack #3        ", read_uint(fp)
            print "Attack #4        ", read_uint(fp)
            print

        if len(fp.read(1)) != 0:
            print "ERROR: Unexpected end of file"
            print "       Are these really %d attacks and %d monsters?" % \
                (number_of_attacks, number_of_monsters)
            print fp.read(20)
    finally:
        fp.close()

if __name__ == '__main__':
    if len(sys.argv) == 0 or sys.argv[1] == "-v":
        print "usage: <dexalyse> (filename.dex )+"
        print
        print "SEP 2011, python script dexalyse"
        raise SystemExit()

    for arg in sys.argv[1:]:
        dexalyse(arg)
        print "Job done. Bye."
