const options = [
    String.raw`from random import randint

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

get_random_squares(min=1, max=10)`,

    String.raw`from turtle import Screen, Turtle

# Set up screen
screen = Screen()
screen.setup(300, 300)

# Set up Turtle position
turtle = Turtle()
turtle.penup()
turtle.goto(-50, -50)
turtle.pendown()

# Draw a square with each side being a different color
for color in ['red', 'green', 'yellow', 'blue']:
  turtle.color(color)
  turtle.forward(100)
  turtle.left(90)

screen.exitonclick()`,

    String.raw`from random import randint

# If the number is divisible by 3, print fizz
# If it is divisible by 5, print buzz
for i in range(10, randint(10, 50)):
  print(f"{i} ", end="")
  if not i % 3:
      print("fizz", end="")
  if not i % 5:
      print("buzz", end="")
  print()
  `,
];

export default String.raw`"""
Welcome to Pytho!
---
In this environment, you can create and share
your Python code with the world.

Try reloading to get another example, or dig
right in and write your own code!
"""

${options[Math.floor(Math.random() * options.length)]}
`;
