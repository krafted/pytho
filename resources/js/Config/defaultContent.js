export default String.raw`import turtle

wn = turtle.Screen()
wn.setup(500, 500)

babbage = turtle.Turtle()
babbage.shape("triangle")
babbage.penup()
babbage.goto(45, 90)
babbage.pendown()

n = 8
angle = 360/n

for i in range(n):
    babbage.right(angle)
    babbage.forward(90)
    babbage.stamp()

wn.exitonclick()
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
