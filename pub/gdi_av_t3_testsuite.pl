#!/usr/bin/perl -w

use strict;
use warnings;

my $regex = "b*a((bb)+|aa?bb*a)*";

my %test_suite = (
    # test length < 3
    "", 0,
    "a", 1,
    "b", 0,
    "aa", 0,
    "ab", 0,
    "ba", 1,
    "bb", 0,

    # test lower ring
    "bab", 0,
    "babb", 1,
    "babbb", 0,
    "babbbb", 1,

    # testing first two letters of upper ring
    "baaaa", 0,
    "baba", 0,
    "baaba", 0,

    # testing last letters of upper ring
    "baaba", 1,
    "baaabb", 0,
    "babbab", 0,
    "baaabba", 1,
    "baabbba", 1,
    "baaabbbba", 1,

    # combining both rings
    "babbaba", 1,
    "babbaabbbba", 1);

my $rc = 0;
while ((my $string, my $result) = each(%test_suite)) {
    if (($string =~ /^${regex}$/g) == $result) {
        print "Test suite passed (" . $string . ")\n";
    } else {
        print "Test suite FAILED (" . $string . ")\n";
        $rc = 1;
    }
}

exit $rc;
