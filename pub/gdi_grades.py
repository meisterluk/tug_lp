#!/usr/bin/env python

import itertools

rate = lambda x: dict(((True, 2), (False, 0), (None, 0)))[x]
grades = [sum([rate(y) for y in x]) for x in itertools.product((True, False, None), repeat=8)]

print grades # all combinations
print 'There are %d different grades' % len(grades)
g = float(len(grades))

# filters
negative = lambda x: x < 9
positive = lambda x: x > 8
four = lambda x: 8 < x < 11
three = lambda x: 10 < x < 13
two = lambda x: 10 < x < 13
one = lambda x: 10 < x < 13

# filters to numbers
n = map(negative, grades).count(True)
p = map(positive, grades).count(True)
f = map(four, grades).count(True)
t = map(three, grades).count(True)
w = map(two, grades).count(True)
o = map(one, grades).count(True)

print 'negativ: %d (%.1f%%)' % (n, 100*n/g)
print 'positiv: %d (%.1f%%)' % (p, 100*p/g)
print '4: %d (%.1f%%)' % (f, 100*f/p)
print '3: %d (%.1f%%)' % (t, 100*t/p)
print '2: %d (%.1f%%)' % (w, 100*w/p)
print '1: %d (%.1f%%)' % (o, 100*o/p)
