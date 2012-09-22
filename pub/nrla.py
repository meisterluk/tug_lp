#!/usr/bin/env python

"""
    A small script demonstrating basic operations
    in linear algebra using numpy

    * http://docs.scipy.org/doc/scipy/reference/
    * http://docs.scipy.org/doc/numpy/reference/
"""

import numpy
import scipy.linalg
import scipy.sparse

def chapter(title):
    """Print chapter header"""
    print
    print(title)
    print("=" * len(title))
    print

a = numpy.matrix(((1, 2, 3),
                  (2, 3, 4),
                  (4, 5, 6)))
b = numpy.matrix(((1, 2, 5),
                  (2, 3, 4),
                  (4, 1, 6)))
print("a = ")
print(a)
print("b = ")
print(b)

chapter("Basic attributes")
print("Matrix a has {} elements and is a {}x{} matrix"
      .format(a.size, *a.shape))
print("It's greatest element is {}"
      .format(a.argmax()))

chapter("Matrix addition")
print(a + b)

chapter("Matrix subtraction")
print(a - b)

chapter("Matrix multiplication")
print(a * b)
# is not commutative: a * b <> b * a
# is associative:     (a * b) * c = a * (b * c)
# is distributive:    (a + b) * c = a * c + b * c

chapter("Scalar addition")
print(5 + a)

chapter("Scalar multiplication")
print(5 * a)

chapter("Power of matrix a")
print(a**2)

chapter("Null matrix")
print(numpy.zeros((a.shape[0], a.shape[1])))

chapter("Identity matrix")
print(numpy.eye(a.shape[0]))

chapter("Negative matrix")
print(-a)

chapter("Inverse matrix")
print("A * X = X * A = I   A=M(n,n), X=M(n,n), I=identity matrix")
# Well... a and b are singular
c = numpy.matrix(((1, -1), (-1, 2)))
inv = numpy.linalg.inv(c)
print(c.getI()) # == inv
# if inverse exists, matrix is regular
# if inverse does not exist, matrix is singular

# a*b  is regular, if  (a*b)^-1 = b^-1 * a^-a
# a^-1 is regular, if  (a^-1)^-1 = a
# a^t  is regular, if  (a^t)^-1 = (a^-1)^t

chapter("transposed matrix")
# methods for matrizes only
a.getT() # no conjugate
a.getH() # conjugate

# method for arrays too
print(a.transpose())


chapter("Diagonal matrix")
print("The diagonal matrix of a is: ")
print(numpy.diag(a))

chapter("Upper triangular matrix")
print(scipy.sparse.triu(a).todense())

chapter("Lower triangular matrix")
print(scipy.sparse.tril(a).todense())

chapter("Symmetrical matrix")
# A^T = A
print((a.transpose() == a).all())

chapter("Rang (no builtin)")
u, s, v = numpy.linalg.svd(a)
rank = numpy.sum(s > 1e-10)
print(rank)
# numpy is going to ship numpy.linalg.matrix_rank

chapter("LU decomposition")
lu = scipy.linalg.lu_factor(a)
print(lu)
lu = scipy.linalg.lu_solve(lu, b)
print(lu)

chapter("Solving A*X=B")
a = numpy.array([[3, 1], [1, 2]])
b = numpy.array([9, 8])
x = numpy.linalg.solve(a, b)
print(x)
print()
print('... is the solution for a * x = b')

print(numpy.dot(a, x) == b)
print(numpy.dot(a, x) == b).all()

chapter("Determinant")
print(numpy.linalg.det(a))
