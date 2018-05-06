var wsUrl = "ws://47.104.213.134"
var websocket = new WebSocket(wsUrl);
websocket.onopen = function (evt) {
    console.log("连接websocket成功");
}
websocket.onmessage = function (e) {
    console.log('推送的数据：', e.data)
}
websocket.onclose = function () {
    console.log("close")
}
websocket.onerror = function () {
    console.log('error')
}