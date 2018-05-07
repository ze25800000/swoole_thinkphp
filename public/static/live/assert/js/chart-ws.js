var wsUrl = "ws://47.104.213.134/char"
var websocket = new WebSocket(wsUrl);
websocket.onopen = function (evt) {
    console.log("聊天室连接websocket成功");
}
websocket.onmessage = function (e) {
    console.log(e.data)

}
websocket.onclose = function () {
    console.log("close")
}
websocket.onerror = function () {
    console.log('error')
}

function push(data) {
    // console.log(JSON.parse(data))
}