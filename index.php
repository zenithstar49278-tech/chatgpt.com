<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🌸 ChatGPT Clone 🌸</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #E6E6FA, #FFD6E0);
      color: #1A1A2E;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .chat-container {
      width: 100%;
      max-width: 600px;
      height: 90vh;
      background: white;
      border-radius: 20px;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }
    .chat-header {
      background: linear-gradient(90deg, #FF69B4, #5AC8FA, #A6FFCB);
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 1.4rem;
      font-weight: bold;
    }
    .chat-box {
      flex: 1;
      padding: 15px;
      overflow-y: auto;
      background: #FDFDFD;
    }
    .message {
      margin: 10px 0;
      padding: 10px 14px;
      border-radius: 12px;
      max-width: 80%;
      word-wrap: break-word;
    }
    .user {
      background: #FF914D;
      color: white;
      margin-left: auto;
    }
    .assistant {
      background: #5AC8FA;
      color: white;
      margin-right: auto;
    }
    .chat-input {
      display: flex;
      border-top: 2px solid #eee;
    }
    .chat-input input {
      flex: 1;
      padding: 12px;
      border: none;
      outline: none;
      font-size: 1rem;
    }
    .chat-input button {
      background: linear-gradient(90deg, #FF69B4, #5AC8FA);
      color: white;
      border: none;
      padding: 12px 18px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
    }
    .chat-input button:hover {
      opacity: 0.85;
    }
  </style>
</head>
<body>
  <div class="chat-container">
    <div class="chat-header">
      🌸 ChatGPT Clone 🌸
    </div>
    <div class="chat-box" id="chatBox"></div>
    <div class="chat-input">
      <input type="text" id="userInput" placeholder="Type your message..." />
      <button onclick="sendMessage()">Send</button>
    </div>
  </div>

  <script>
    async function sendMessage() {
      const input = document.getElementById("userInput");
      const message = input.value.trim();
      if (!message) return;

      // Display user message
      const chatBox = document.getElementById("chatBox");
      chatBox.innerHTML += `<div class="message user">${message}</div>`;
      input.value = "";

      // Send to backend (chat.php)
      const response = await fetch("chat.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message })
      });

      const data = await response.json();
      const reply = data.reply || "⚠️ No response from AI";

      // Display assistant reply
      chatBox.innerHTML += `<div class="message assistant">${reply}</div>`;
      chatBox.scrollTop = chatBox.scrollHeight;
    }
  </script>
</body>
</html>
