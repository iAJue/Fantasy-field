<?php if(!defined('APP_PATH')) {exit('error!');}?>
    <!-- 图片展示 -->
    <div class="details">
        <img src="<?php echo 'https://ws3.sinaimg.cn/large/'.$picid;?>" id="pic" class="pic">
    </div>
    <!-- 用户信息 -->
    <div class="userinfo"> 
        <img src="<?php echo $portrait;?>" class="portrait"><span class="user-link"><?php echo $user;?></span>
    </div>
    <!-- 功能 -->
    <div class="codeinfo">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active" id="about"><a>关于</a></li>
            <li role="presentation" id="code"><a>嵌入代码</a></li>
        </ul>
        <!-- 关于 -->
        <div class="uploadetime">
            <span>上传于<?php echo $time;?></span>
        </div>
        <div class="panel-share">
            <h4 class="pre-title">图片链接</h4>
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">图片链接</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo PATH_URL.$picid;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">图片URL</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo 'https://ws3.sinaimg.cn/large/'.$picid;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">缩略图URL</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo 'https://ws3.sinaimg.cn/'.$level.'/'.$picid;?>">
                    </div>
                </div>
            </div>
            <h4 class="pre-title">图片嵌入代码</h4>
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">HTML</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="&lt;<?php echo "img src=&quot;https://ws3.sinaimg.cn/large/$picid&quot;"?>&gt;">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">BBCode</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="[img]<?php echo 'https://ws3.sinaimg.cn/large/'.$picid;?>[/img]">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Markdown</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="![](<?php echo 'https://ws3.sinaimg.cn/large/'.$picid;?>)">
                    </div>
                </div>
            </div>
            <h4 class="pre-title">图像链接 + 图片嵌入代码</h4>
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">HTML</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="&lt;a href=&quot;<?php echo PATH_URL.$picid;?>&quot;&gt;&lt;img src=&quot;<?php echo 'https://ws3.sinaimg.cn/large/'.$picid;?>&quot;&gt;&lt;/a&gt;">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">BBCode</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="[url=<?php echo PATH_URL.$picid;?>][img]<?php echo 'https://ws3.sinaimg.cn/large/'.$picid;?>[/img][/url]">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Markdown</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="[![](<?php echo 'https://ws3.sinaimg.cn/large/'.$picid;?>)](<?php echo PATH_URL.$picid;?>)">
                    </div>
                </div>
            </div>
            <h4 class="pre-title">缩略图链接 + 图片嵌入代码</h4>
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">HTML</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="&lt;a href=&quot;<?php echo PATH_URL.$picid;?>&quot;&gt;&lt;img src=&quot;<?php echo 'https://ws3.sinaimg.cn/'.$level.'/'.$picid;?>&quot;&gt;&lt;/a&gt;">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">BBCode</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="[url=<?php echo PATH_URL.$picid;?>][img]<?php echo 'https://ws3.sinaimg.cn/'.$level.'/'.$picid;?>[/img][/url]">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Markdown</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="[![](<?php echo 'https://ws3.sinaimg.cn/'.$level.'/'.$picid;?>)](<?php echo PATH_URL.$picid;?>)">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $(function(){
        $('input').click(function(){
            $(this).select();
        });
        $('#pic').click(function(){
            if ($("#pic").height() >= '500') {
                $('#pic').toggleClass('img');
                $('.details').toggleClass('detailst');
            }
        });
        $('#about').click(function(){
            if(!$(this).hasClass("active")){
                $('#about').toggleClass('active');
                $('#code').removeClass('active');
                $('.panel-share').css('display','none');
                $('.uploadetime').css('display','block');
            }
        });
        $('#code').click(function(){
            if(!$(this).hasClass("active")){
                $('#code').toggleClass('active');
                $('.panel-share').css('display','block');
                $('.uploadetime').css('display','none');
                $('#about').removeClass('active');
            }
        });
    })
    </script>
  </body>
</html>