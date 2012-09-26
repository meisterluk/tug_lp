% Prolog introduction
% PROgrammation en LOGique.
%
% compiled in SWI prolog.
%
% 3 different types of predicates:
%
%    * query
%    * facts (with[out] arguments)
%    * rules
%
% Variables are written with capital letter at beginning.
% Atoms are written with lowercase letter at beginning.
%
% If you start the interpreter at CLI with "prolog", you will enter
% query mode. Only queries can be executed. You can "import" the source
% file with declarations using "[filename].".
%
% If you program in prolog, you are always programming against a truth
% value. So you are describing the program in a way that only the correct
% result evaluates to true. prolog is kind of strange as far as it will
% tell you only true or false for a lot of error classes.
% The interpreter mechanism behind prolog is proof by contradiction. Each
% statement can be transformed in a logical clause and satisfying the overall
% logical clause results in all possible results.

istrue. % fact
share_property(A, B). % fact with arguments (variable, variable)
same(A, A). % fact with arguments (variable, same variable)
isfive(5). % fact with argument (5)

% possible queries to those facts:
%
% ?- istrue.
% true.
%
% ?- share_property(5,6).
% true.
%
% ?- same(5, 5).
% true.
%
% ?- same(6, 5).
% false.
%
% ?- isfive(5).
% true.
%
% ?- isfive(6).
% false.
%
% ?- isfive(A).
% A = 5.
%

istrue(_). % "_" is the special 'I do not care' variable
           % actually every variable with a leading underscore does not care

% facts database.

plant(flower).
plant(rice).
plant(wheat).
plant(curry).
human(socrates).
human(colmerauer).
human(lukas).
human(curry).

% ?- human(X).
% X = socrates ;
% X = colmerauer ;
% X = lukas ;
% X = curry.
%
% ?-

% rules.
% A rule consists a head (left of ":-") and a body.

lifeform(Object) :- plant(Object).
lifeform(Object) :- human(Object).

% rules defined parallel. Represents OR clause: A lifeform is a plant
% OR a human. A rule with comma-separated clauses in the body, represent
% AND clauses.

ambiguous(Object) :- plant(Object), human(Object).

% ?- ambiguous(socrates).
% false.
%
% ?- ambiguous(curry).
% true.
%
% ?- ambiguous(X).
% X = curry.

%%%%% DEBUGGING %%%%%

% trace.
% debug.

%%%%% CUTS %%%%%

% Cuts cut backtracking decision trees.
% The only usecase of cuts is performance.

% - A cut cuts all predicates after it.
% - A cut cuts all alternative solution for conjunction
%   of the solution to the left of the cut in the predicate.
% - A cut does not interfere with solutions to the left of the clause.
% - A predicate with a cut can return more than 1 solution.
%
% You want to add cuts in real world examples, if you already have found
% all possible solutions and want to avoid the search for other solutions,
% which will fail for sure.
%
% You can identify two types of cuts:
%   Green cuts -> changes with logical semantic.
%   Red cuts -> changes with operational semantic.
%
% Red cuts will be created if you delete all clauses which are no more
% meaningful because of a green cut. This changes the operational semantics
% of the source code and it therefore 'dirty'.

% probably this example might explain cuts behaviour.
names(lukas).
names(felix).

check1(A, B) :- names(A), !, names(B).

% ?- check1(A, B).
% A = lukas,
% B = lukas ;
% A = lukas,
% B = felix.

check2(A, B) :- names(A), !, names(B).
check2(1, 2). % will not be matched.

% ?- check2(A, B).
% A = lukas,
% B = lukas ;
% A = lukas,
% B = felix.

% Other tricks.

cannot_be_true(_) :- fail.
oneoption(A) :- not(A = lukas).

% ?- cannot_be_true(A).
% false.
%
% ?- oneoption(A).
% false.
%
% ?- oneoption(lukas).
% false.
%
% ?- oneoption(felix).
% true.

%%%%% RECURSION %%%%%

% Resolve a recursive path deterministically.

% represents a graph tree.
way(a, b).
way(a, c).
way(b, d).
way(b, e).
way(d, f).

connect(Start, Start).
connect(Start, End) :- way(Start, Middle), connect(Middle, End).

% ?- connect(a, f).
% true .
% 
% ?- connect(b, c).
% false.

% The following algorithm is tail recursive.

amean([], Mean, Sum, Count) :- Mean is Sum // Count.
amean([Element|List], Mean, Sum, Count) :-
    SumNew is Sum + Element,
    CountNew is Count + 1,
    amean(List, Mean, SumNew, CountNew).
arithmetic_mean(List, Mean) :- amean(List, Mean, 0, 0).

% The idea of accumulator variables (iterate recursively and process
% if you go be the recursion stack) helps you to make a recursive
% algorithm tail-recursive.
%
% tail-recursive is nice, because it works stackless.

minimum([], Min, Min).
minimum([L|List], Min, CurrentMin) :-
    L < CurrentMin,
    minimum(List, Min, L).
minimum([L|List], Min, CurrentMin) :-
    L >= CurrentMin,
    minimum(List, Min, CurrentMin).
minimum([L|List], Min) :- minimum(List, Min, L).

% another way to do it:
%
% minimum([L|List], Min, CurrentMin) :-
%     L < CurrentMin,
%     !,
%     minimum(List, Min, L).
% minimum([_L|List], Min, CurrentMin) :-
%     minimum(List, Min, CurrentMin).

% a little bit of math

% recursive cube with accumulator variables
cube(_Var, Cube, Cube, 0) :- !.
cube(Var, Cube, Acc, Count) :-
    Count2 is Count - 1,
    Acc2 is Var * Acc,
    cube(Var, Cube, Acc2, Count2).
cube(Var, Cube) :- cube(Var, Cube, 1, 3).

% most intuitive cube.
cubic(Var, Cube) :- Cube is Var * Var * Var.
% cubic(Var, Var * Var * Var). % impossible, no operators in arguments!

% Find zero-based index of maximum index.

index_max([], MaxIndex, _CurrentIndex, AccuIndex, _Max) :-
    MaxIndex is AccuIndex + 1.
index_max([L|List], Index, CurrentIndex, _AccuIndex, AccuMax) :-
    L > AccuMax,
    NextIndex is CurrentIndex + 1,
    index_max(List, Index, NextIndex, CurrentIndex, L).
index_max([L|List], Index, CurrentIndex, AccuIndex, AccuMax) :-
    L =< AccuMax,
    NextIndex is CurrentIndex + 1,
    index_max(List, Index, NextIndex, AccuIndex, AccuMax).
index_max([L|List], Index) :- index_max(List, Index, 0, 0, L).

%%%%% FUNCTORS %%%%%

old(person(_Name, Age)) :- Age > 50.

% ?- old(person(lukas, 42)).
% false.
%
% ?- old(person(lukas, 90)).
% true.
%
% ?- old(person(socrates, 70)).
% true.
%
% ?- old(90).
% false.

%%%%% LISTS %%%%%

% Loops are simulated by recursion.

ismember([X|_], X).
ismember([_|Xs], Element) :- ismember(Xs, Element).

% ?- ismember([1,42,3,2],42).
% true .

count([], _Element, _Count).
count([L|Ls], L, Count) :-
    C is Count + 1,
    count(Ls, L, C).
count([_L|Ls], Element, Count) :- count(Ls, Element, Count).

%%%%% DFA %%%%%
% Deterministic Finite Automaton.

initial_state(s0).
final_state([s0, s3]).

%   D    B
%   |   / \
%   y  x   y
%   | /     \
%   A ---y-- C
%
%   where A is inital state and {A, D} are final states.
%   RegEx: (xyy)*y?
%   {A, B, C, D} -> {s0, s1, s2, s3}

delta(s0, x, s1).
delta(s1, y, s2).
delta(s2, y, s0).
delta(s0, y, s3).

find_delta([], State) :-
    final_state(A),
    ismember(A, State).
find_delta([Symbol|Sequence], State) :-
    delta(State, Symbol, Next),
    find_delta(Sequence, Next).
dfa_accepts(Sequence) :-
    initial_state(S),
    find_delta(Sequence, S).

% ?- dfa_accepts([]).
% true .
%
% ?- dfa_accepts([y]).
% true .
%
% ?- dfa_accepts([x,y,y,x,y,y,y]).
% true .


