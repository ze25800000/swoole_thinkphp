var wsUrl = "ws://47.104.213.134"
var websocket = new WebSocket(wsUrl);
websocket.onopen = function (evt) {
    console.log("连接websocket成功");
}
websocket.onmessage = function (e) {
    console.log(e.data)
    push(e.data);

}
websocket.onclose = function () {
    console.log("close")
}
websocket.onerror = function () {
    console.log('error')
}

function push(data) {
    console.log(JSON.parse(data))
    var data = JSON.parse(data),
        html = `<div class="frame">
                <h3 class="frame-header">
                    <i class="icon iconfont icon-shijian"></i>第${data.type}节 01：30
                </h3>
                <div class="frame-item">
                    <span class="frame-dot"></span>
                    <div class="frame-item-author">
                        <img src="./imgs/team${data.team_id === 1 ? 1 : 2}.png" width="20px" height="20px"/> 马刺
                    </div>
                    <p>08:44 ${data.content}</p>
                    <p>08:44 帕克 犯规 fuck you 2次</p>
                </div>
                <div class="frame-item">
                    <span class="frame-dot"></span>
                    <div class="frame-item-author">
                        bnimabi(评论员)
                    </div>
                    <p>01:44 </p>
                    <p>01:46 犯规 caonima Ruan</p>
                </div>
            </div>`
    $('#match-result').prepend(html);
}