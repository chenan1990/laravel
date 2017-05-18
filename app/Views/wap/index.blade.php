<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    <?php
    $app = new \EasyWeChat\Foundation\Application(config('wechat'));
    $js = $app->js;
    ?>
    wx.config(<?php echo $js->config(array('getNetworkType', 'chooseImage'), true) ?>);
    wx.ready(function(){
        wx.getNetworkType({
            success: function (res) {
                var networkType = res.networkType; // 返回网络类型2g，3g，4g，wifi
            }
        });

        wx.checkJsApi({
            jsApiList: ['chooseImage'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
            success: function(res) {
                alert(res);
                // 以键值对的形式返回，可用的api值true，不可用为false
                // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
            }
        });
    });


</script>
