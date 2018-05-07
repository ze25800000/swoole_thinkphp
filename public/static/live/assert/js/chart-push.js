$('#discuss-box').keydown(function (event) {
    var $this = $(this)
    if (event.keyCode === 13) {
        var text = $this.val()
        var url = 'http://47.104.213.134/?s=index/chart/index'
        var data = {
            content: text,
            game_id: 1
        }
        $.get(url, data, function (result) {
            $this.val('')
        }, 'json')
    }
})