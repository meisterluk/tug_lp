#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys
enc = sys.stdin.encoding
hex = lambda num: u'%02X' % num

def umlauts(string):
    """Replace umlauts"""
    alloc = {
        u'\u00E4' : u'ae', u'\u00C4' : u'AE',
        u'\u00F6' : u'oe', u'\u00D6' : u'OE',
        u'\u00FC' : u'ue', u'\u00DC' : u'UE',
        u'\N{LATIN SMALL LETTER SHARP S}' : u'ss',
    }
    for key in alloc:
        string = string.replace(key, alloc[key])
    return string

# request mode
mode = 'invalid'
while mode not in ('ascii', 'hex'):
    mode = raw_input('Generate (ascii) or (hex)? ')

# request name
name = 'invalid'
while len(name.split(' ')) != 2 and len(name) > 2:
    name = raw_input('Enter name: ').decode(enc)

# create filename
_filename = umlauts(name.lower().replace(' ', ''))
filename1 = '%s.%s.input.txt' % (_filename, mode)
filename2 = '%s.%s.output.txt' % (_filename, mode)

content = umlauts(name)

if mode == 'ascii':
    with open(filename1, 'w') as fp:
        content = [ord(letter) for letter in content]
        scontent = sorted(content)
        content = [str(letter) for letter in content]
        content.insert(0, unicode(len(content)))
        content = u'\n'.join(content)
        scontent = u'\n'.join([unicode(l) for l in scontent])
        fp.write(content.encode(enc))

    with open(filename2, 'w') as fp:
        fp.write(scontent.encode(enc))

elif mode == 'hex':
    with open(filename1, 'w') as fp:
        content = [hex(ord(letter)) for letter in content]
        scontent = sorted(content)
        content.insert(0, hex(len(content)))
        content = u'\n'.join(content)
        scontent = u'\n'.join(scontent)
        fp.write(content.encode(enc))

    with open(filename2, 'w') as fp:
        fp.write(scontent.encode(enc))

print 'Job Done.'
