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
<script type="text/javascript" charset="UTF-8">
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
        $(window).resize(function() {
            clearTimeout(timer)
            screen.getsize();
            xx("resize:w:"+screen.width+":h:"+screen.height);
            imageResize();
            setActiveImage(0);
        });

        imageResize();
        function imageResize(){
            node.items.each(function (index) {
                //裡面不會依照img順序執行，會依照「先載完的圖片」執行
                $(this).on('load', function(){
//                xx($(this));
                    fitImageToScreen($(this),getImageSize($(this)));
                });
            });
        }


        //step3. start slider animate

        setActiveImage(0);
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
//            xx("img:w:" + image['width'] + ":h:" + image['height']);
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
//            console.log('self:w:'+self.width+'h:'+self.height);
        }
        self.getsize = function(){
            var ret = {};
            ret['width'] = $(window).width();//document.documentElement.clientWidth; //documentElement=>change body?
            ret['height'] = $(window).height();//document.documentElement.clientHeight;
            $(window).height()
            self.width = ret['width'];
            self.height = ret['height'];
            //TODO valudate!=0
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



    function isMobile(){
        var isMobile = false;
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4)))
            isMobile = true;
        return isMobile;
    }

    $(document).ready(function(){
        $("img").load(function() {
        });
    });

</script>
</html>
