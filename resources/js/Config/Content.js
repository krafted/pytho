export default String.raw`"""
Welcome to Py!
---
In this environment, you can create and share
your Python code with the world.
"""

from random import randint

# Produces a list of random numbers and their squares.
# Random numbers start at min and end at max.
def get_random_squares(min, max):
  n = randint(min, max)
  nums = [str(num) for num in range(min, n + 1)]
  squares = [str(num ** 2) for num in range(min, n + 1)]
  row_format ="\t{:<3}" * 3

  print(f"Squares 1..{n}:\n")
  for num, square in zip(nums, squares):
    print(row_format.format(num, '=>', square))

get_random_squares(min=1, max=10)
`
