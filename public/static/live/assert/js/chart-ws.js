var wsUrl = "ws://47.104.213.134/char"
var websocket = new WebSocket(wsUrl);
websocket.onopen = function (evt) {
    console.log("聊天室连接websocket成功");
}
websocket.onmessage = function (e) {
    push(e.data)
}
websocket.onclose = function () {
    console.log("close")
}
websocket.onerror = function () {
    console.log('error')
}

function push(data) {
    var data = JSON.parse(data),
        html = `<div class="comment">
                <span>${data.user}</span>
                <span>${data.content}</span>
            </div>`
    $('#comments').prepend(html)
}