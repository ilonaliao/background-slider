<!doctype html>
<html lang="zh-tw">
<head>
<meta charset="UTF-8">
<link href="css/index.css?v=<?= microtime(true); ?>" media="screen, projection" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body>
<div class="slider">
    <img src="http://fredchung.tw/upload/bg/bg_commercial.jpg" class="item">
    <img src="http://www.fotobeginner.com/wp-content/uploads/2014/09/500pxGlobalWalk.jpg" class="item ">
    <img src="https://pbs.twimg.com/media/C1FqvS_XAAAcRX-.jpg" class="item "><!-- 正方形欸-->
    <img src="https://s-media-cache-ak0.pinimg.com/originals/fb/de/63/fbde63c09f3e41f365623ad26589d6c6.jpg" class="item actived">
    <img src="https://drscdn.500px.org/photo/216370631/m%3D900_s%3D1_k%3D1_a%3D1/v2?webp=true&v=0&sig=ce2fef7759b2c34bbc121aef08bd42032c1bbb190812d36307ef95d5018eb6cb" class="item ">
    <div class="nav"></div>
</div>

</body>
<script type="text/javascript">
    function xx(i){ console.log(i); }
    function Slider(setting){
        var screen = new Screen();
        var timer;
        var node = {};
        node.slider = $('.slider');
        node.nav = $('.nav');
        node.items = node.slider.find('.item');

        //step1. append nav to html
        createNavhtml(node.items.length);
        node.cycles = node.nav.find('span');

        //step2. image resize to screen
        image = getImageSize(node.slider.find('img.actived'));
        imageResize('first');
        $(window).resize(function() {
            clearTimeout(timer);
            screen.getsize();
            xx("resize:w:"+screen.width+":h:"+screen.height);
            removeImageStyle(node.items);
            imageResize('resize');
            setActiveImage(0);
        });

        //step3. start slider animate
        setActiveImage(0);

        //step4. click nav
        $('body').on('click','span',function(){
            clearTimeout(timer);
            setActiveImage($(this).index());
        });


        function imageResize(status='first'){
            if(status == 'resize'){
                node.items.each(function (index) {
                   fitImageToScreen($(this),getImageSize($(this)));
                });
            }else{
                node.items.each(function (index) {
                    //裡面不會依照img順序執行，會依照「先載完的圖片」執行(第一次載才會觸發on load)
                    $(this).on('load', function(){
                        xx($(this));
                        fitImageToScreen($(this),getImageSize($(this)));
                    });
                });
            }

        }

        function removeImageStyle(dom){
            dom.removeAttr("style");
        }


        function setActiveImage(itemIndex){
            node.items.each(function (index) {
                if(index == itemIndex){
                    node.items.removeClass('actived');
                    $(this).addClass('actived');
                    node.cycles.removeClass('actived');
                    node.cycles.eq(index).addClass('actived');
                    timer = setTimeout(function(index){
                        if(index == node.items.length) index = 0;
                        setActiveImage(index);
                    }, 1000, index + 1);
                }
            });
        }

        function fitImageToScreen(dom,image){
            var movePx = 0;
            var newImageSize = {};

            if(image.height - screen.height < 0){
                dom.css('height','100%');
                newImageSize = getImageSize(dom);
                movePx = (newImageSize['width'] - screen.width) / 2;
                if(movePx >= 0){
                    dom.css('left','-'+movePx+'px');
                }else{
                    //有空白露出
                    dom.css('height','initial');
                    dom.css('width','100%');
                    newImageSize = getImageSize(dom);
                    movePx = (newImageSize['height'] - screen.height) / 2;
                    dom.css('top','-'+movePx+'px');
                }
            }else{
                dom.css('width','100%');
                newImageSize = getImageSize(dom);
                movePx = (newImageSize['height'] - screen.height) / 2;
                if(movePx >= 0){
                    dom.css('top','-'+movePx+'px');
                }else{
                    //有空白露出
                    dom.css('width','initial');
                    dom.css('height','100%');
                    newImageSize = getImageSize(dom);
                    movePx = (newImageSize['width'] - screen.width) / 2;
                    dom.css('left','-'+movePx+'px');
                }
            }

        }

        function getImageSize(dom){
            var ret = {};
            ret['width'] = dom.width();
            ret['height'] = dom.height();
            return ret;
        }

        function createNavhtml(count){
            var headHtml = '<span class="actived"></span>';
            var spanHtml = '<span></span>';
            var ret = '';
            if(count != 0){
                for(var i = 1 ; i<=count ; i++){
                    if(ret=='')
                        ret = headHtml;
                    else
                        ret += spanHtml;
                }
            }
            node.nav.append(ret);
        }
    }
    new Slider({
        speed:1000,
    });


    function Screen(){
        var self = this;
        self.width = null;
        self.height = null;
        self.init = function(){
            self.getsize();
        }
        self.getsize = function(){
            var ret = {};
            ret['width'] = $(window).width();//document.documentElement.clientWidth; //documentElement=>change body?
            ret['height'] = $(window).height();//document.documentElement.clientHeight;
            $(window).height()
            self.width = ret['width'];
            self.height = ret['height'];
            return ret;
        }
        //isLandscape = 橫式螢幕
        self.isLandscape = function(){
            var ret = true;
            if(self.width < self.height)
                ret = false;
            return ret;
        }
        self.init();
    }


</script>
</html>
