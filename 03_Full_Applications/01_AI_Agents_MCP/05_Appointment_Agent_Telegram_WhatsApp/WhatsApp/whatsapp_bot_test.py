from flask import Flask, request, Response
from twilio.twiml.messaging_response import MessagingResponse

app = Flask(__name__)


@app.post("/webhook")
def webhook():
    text = request.values.get("Body", "").strip()

    resp = MessagingResponse()
    resp.message(text if text else "Received.")

    return Response(str(resp), mimetype="text/xml")


if __name__ == "__main__":
    print("Starting Flask app on port 5000...")
    app.run(host="0.0.0.0", port=5000)