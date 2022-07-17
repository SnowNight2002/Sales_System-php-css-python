'''
How to create a simple REST API with Python and Flask in 5 minutes
https://medium.com/duomly-blockchain-online-courses/how-to-create-a-simple-rest-api-with-python-and-flask-in-5-minutes-94bb88f74a23
https://pythonbasics.org/flask-tutorial-routes/
run : pip install flask
Testing :
URL : http://127.0.0.1:8080/api/apple/30
output on browser :
{
  "para1": "apple",
  "para2": "30"
}
'''

from flask import Flask

app = Flask(__name__)


@app.route("/api/<total>/<discount>")
def process(total=None, discount=None):
    # processing of request data goes here ...
    x = int(total);

    if x >= 10000:
        discount = x * (1 - 0.12)
    elif x >= 5000:
        discount = x * (1 - 0.08)
    elif x >= 3000:
        discount = x * (1 - 0.03)
    else:
        discount = x
    response_data = {"total": total, "discount": discount}
    return response_data


if __name__ == "__main__":
    app.run(debug=True,
            host='127.0.0.1',
            port=8080)
