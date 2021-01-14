export default String.raw`import turtle

screen = turtle.Screen()
screen.setup(500, 500)

t = turtle.Turtle()
t.shape("triangle")
t.penup()
t.goto(45, 90)
t.pendown()

for i in range(8):
    t.right(45)
    t.forward(90)
    t.stamp()

screen.exitonclick()
`
// """
// Welcome to Py!
// """

// from random import randint

// # Produces a list of random numbers and their squares.
// # Random numbers start at min and end at max.
// def get_random_squares(min, max):
//   n = randint(min, max)
//   nums = [str(num) for num in range(min, n + 1)]
//   squares = [str(num ** 2) for num in range(min, n + 1)]
//   row_format ="\t{:<3}" * 3

//   print(f"Squares 1..{n}:\n")
//   for num, square in zip(nums, squares):
//     print(row_format.format(num, '=>', square))

// get_random_squares(min=1, max=10)
