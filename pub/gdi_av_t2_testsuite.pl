#!/usr/local/bin/perl -w

use strict;
use warnings;

my $regex = "(b?(ab)+a?|a?(ba)+b?|a|b|)";

# original by AngabeVier
my %test_suite = ("", 1, "a", 1, "baba", 1, "ababa", 1,
    "aa", 0, "abaa", 0, "bbbab", 0, "babbab", 0);

# extended to other examples
my %extended_test_suite = ("b", 1, "abab", 1, "babab", 1,
    "bb", 0, "babb", 0, "aaaba", 0, "babab", 1, "bbabaa", 0);

my %testsuite = (%test_suite, %extended_test_suite);

my $rc = 0;
while ((my $string, my $result) = each(%testsuite)) {
    if (($string =~ /^${regex}$/g) == $result) {
        print "Test suite passed (" . $string . ")\n";
    } else {
        print "Test suite FAILED (" . $string . ")\n";
        $rc = 1;
    }
}

exit $rc;
