<?php
    /** @var $this \yii\web\View */
    /** @var $zones \app\models\Zone[] */
    /** @var $docs \app\modules\admin\forms\DocForm */
    use yii\helpers\Html;
    use yii\widgets\Pjax;

    $time = new DateTime(\config\Config::getValue('timer'));
    $diff = $time->diff(new DateTime());
    $days = $diff->days;
    $factor = $days % 10;

    if ($factor == 0 || $factor >= 5 || ($days <= 15 && $days >= 11)) {
        $pluralDays = 'дней';
    } else if ($factor == 1) {
        $pluralDays = 'день';
    } else if ($factor > 1 && $factor < 5) {
        $pluralDays = 'дня';
    }

    $remainTime = $diff->format('%h') * 3600 + $diff->format('%i') * 60 + $diff->format('%s');

?>

<div class="row">
    <div class="logo2">
        <img src="/image/logo.png" alt="">
    </div>
</div>

<div class="hide-slider">
    <div id="myCarousel" class="main-carousel carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php $activ = true; ?>
            <?php foreach ($slide as $img): ?>
                <div class="item <?php echo $activ ? 'active' : ''; ?>">
                    <?php echo Html::img($img->getImageFileUrl('image'), ['class' => 'slide-img']); ?>
                    <div class="container">

                    </div>
                </div>
                <?php $activ = false; ?>
            <?php endforeach; ?>
        </div>

        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

        <div class="logo">
            <img src="/image/logo.png" alt="">
        </div>

        <div class="widget-soc hidden-xs">
            <script type="text/javascript">(function (w, doc) {
                    if (!w.__utlWdgt) {
                        w.__utlWdgt = true;
                        var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
                        s.type = 'text/javascript';
                        s.charset = 'UTF-8';
                        s.async = true;
                        s.src = ('https:' == w.location.protocol ? 'https' : 'http') + '://w.uptolike.com/widgets/v1/uptolike.js';
                        var h = d[g]('body')[0];
                        h.appendChild(s);
                    }
                })(window, document);
            </script>
            <div data-background-alpha="0.0" data-buttons-color="#ffffff" data-counter-background-color="#ffffff"
                 data-share-counter-size="14" data-top-button="false" data-share-counter-type="separate"
                 data-share-style="1" data-mode="share" data-like-text-enable="false" data-mobile-view="false"
                 data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000"
                 data-share-shape="round-rectangle" data-sn-ids="fb.vk." data-share-size="20"
                 data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.vb."
                 data-pid="1553857" data-counter-background-alpha="1.0" data-following-enable="false"
                 data-exclude-show-more="true" data-selection-enable="false" class="uptolike-buttons"></div>
        </div>
        <div class="board light-text">
            <div><?php echo nl2br(\config\Config::getValue('right_top_block')); ?></div>
            <div class="buy-small chapter" data-toggle="modal"
                 data-target="#buyTicketModal"><?php echo nl2br(\config\Config::getValue('text_on_button')); ?>
            </div>
            <div class="to-pdf">*покупая билет, Вы соглашаетесь с <a href="<?php echo $docs->getUploadedFileUrl('visiting_rules'); ?>" target="_blank">правилами посещения фестиваля</a></div>
        </div>
    </div>
</div>

<div class="modal fade" id="buyTicketModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">&times;</button>
                <h3 class="modal-title"
                    id="myModalLabel"><?php echo nl2br(\config\Config::getValue('text_on_button')); ?></h3>
            </div>
            <div class="modal-body">
                <script type="text/javascript">
                    var widgetOptions = {bg_color: 'fcfcfc', id: 703970, lang: 'uk'};
                    (function () {
                        var script = document.createElement('script');
                        script.type = 'text/javascript';
                        script.async = true;
                        script.src = "https://2event.com/js/widget-tickets.js";
                        document.getElementsByTagName('head')[0].appendChild(script);
                    })();
                </script>
                <div id="2event_tickets_widget"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="timer">
            <div class="param light-text2"><?php //Осталось ?></div>
            <div class="param big-text"><?php $days; ?></div>
            <div class="param light-text2"><?php $pluralDays; ?></div>
            <div style="clear:left"></div>
        </div>
    </div>
    <div class="col-sm-6 col-sm-offset-2">
        <div class="date-holder">
            <div>
                <div class="date-yellow "></div>
                <div class="date-white big-text"><?php echo nl2br(\config\Config::getValue('day')); ?></div>
            </div>
            <div class="light-text2"><?php echo nl2br(\config\Config::getValue('date')); ?></div>
        </div>
    </div>
</div>

<div class="row center-text">
    <div class="clocktimer">
        <?php /*
        <div id="clock"></div>
        <div class="row">
            <div class="time-param-holder light-text2">
                <div class="time-param">ЧАСОВ</div>
                <div class="time-param">МИНУТ</div>
                <div class="time-param">СЕКУНД</div>
            </div>
        </div>
        <div id="meter"></div>
        */ ?>
        <div class="fst-bl up active" data-tags="">Роботы, дроны, 3D принтеры – новейшие технологии в одном месте.</div>
        <div class="snd-bl up" data-tags="">Эксперименты и популярная наука - все можно попробовать!</div>
        <div class="thd-bl up" data-tags="">Крутые технические хобби – для детей и взрослых</div>
        <div class="frt-bl up" data-tags="">2 дня мастер-классов и лектория</div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3 footer-row hide-col">
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
    </div>
    <div class="col-sm-6 footer-row footer-stroke-white">
        <div class="chapter"><a name="down1">ЛОКАЦИИ</a></div>
        <div class="slesh">////////////////////////////////////////////////////////////////////////////////////////////////////////////////////</div>
        <div></div>
    </div>
    <div class="col-sm-3 footer-row visible hide-col">
        <div class="footer-col2">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
        <div class="point-holder">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
    </div>
</div>

<div class="container marg">
    <div class="row child-holder2">
        <?php foreach ($zones as $i => $zone): ?>
            <div class="col-md-2 col-sm-3 col-xs-6 no-padding">
                <div class="zone-bar center-text">
                    <a class="to-zone" href="#zone"><?php echo Html::img($zone->getThumbFileUrl('image', 'normal')); ?></a>
                    <div class="text mytitle"><?php echo Html::encode($zone->name); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<a id="zone" name="zone"></a>
<div class="container marg activities-container">
    <div id="secondCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="col-md-12 pop-up carousel-inner" role="listbox">
            <div class="col-xs-2 no-padding" id="prev-but">
                <a class="slide-zone big-text2 left carousel-control" href="#secondCarousel" role="button"
                   data-slide="prev"><</a>
            </div>
            <div class="col-xs-2 no-padding" id="next-but">
                <a class="slide-zone big-text2 right carousel-control" href="#secondCarousel" role="button"
                   data-slide="next">></a>
            </div>

            <?php foreach ($zones as $i => $zone): ?>
                <div class="row marg child-holder item">
                    <div class="wrapper-head-carousel">
                        <div class="row">
                            <div class="col-xs-2 visible no-padding">
                                <div class="button-point-holder left">
                                    <?php echo $this->render('_points', ['num' => 49]); ?>
                                    <div style="clear:left"></div>
                                </div>
                            </div>
                            <div class="col-xs-8  no-padding">
                                <div class="chapter-zone"><?php echo Html::encode($zone->name); ?></div>
                            </div>
                            <div class="col-xs-2 visible no-padding">
                                <div class="button-point-holder right">
                                    <?php echo $this->render('_points', ['num' => 49]); ?>
                                    <div style="clear:left"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text3 marg dess">
                        <div class="col-xs-10 col-xs-offset-1"><?php echo $zone->description; ?></div>
                    </div>

                    <?php foreach ($zone->activities as $activity): ?>
                        <div class="col-md-4 col-sm-6 no-padding">
                            <div class="event-bar">
                                <div class="event-bar-img">
                                    <?php echo Html::img($activity->getThumbFileUrl('image', 'normal')); ?>
                                </div>
                                <div class="text mytitle"><?php echo Html::encode($activity->name); ?></div>
                                <div class="min-text"><?php echo $activity->text; ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3 footer-row hide-col">
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
    </div>
    <div class="col-sm-6 footer-row footer-stroke-white">
        <div class="chapter"><a name="down2">КУПИТЬ БИЛЕТ</a></div>
        <div class="slesh">////////////////////////////////////////////////////////////////////////////////////////////////////////////////////</div>
        <div></div>
    </div>
    <div class="col-sm-3 footer-row visible hide-col">
        <div class="footer-col2">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
        <div class="point-holder">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
    </div>
</div>
<div class="container marg">
    <div id="hide" class="row marg nav nav-tabs" role="tablist">
        <div class="col-md-4 no-padding" role="presentation">
            <button class="reg-bar buy-img"></button>
        </div>
        <div class="col-md-4 no-padding" role="presentation" class="active" style="position: relative;">
            <button class="reg-bar reg-member active-btn" data-toggle="modal" data-target="#buyTicketModal"></button>
            <div class="reg-name text" id="member">КУПИТЬ БИЛЕТ</div>
        </div>
        <div class="col-md-4 no-padding" role="presentation">
            <button class="reg-bar reg-smi"></button>
        </div>

        <div class="tab-content">
            <div id="hide-me1" role="tabpanel" class="tab-pane active">
                <div class="row marg">
                    <div class="col-md-8 col-md-offset-2 no-padding">
                        <div class="text marg">
                            <?php echo nl2br(\config\Config::getValue('buy_ticket')); ?>
                        </div>
                        <div class="news-title text padd">
                            <a href="<?php echo $docs->getUploadedFileUrl('visiting_rules'); ?>" target="_blank">Правила посещения</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3 footer-row hide-col">
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
    </div>
    <div class="col-sm-6 footer-row footer-stroke-white">
        <div class="chapter"><a name="down3">НОВОСТИ</a></div>
        <div class="slesh">////////////////////////////////////////////////////////////////////////////////////////////////////////////////////</div>
        <div></div>
    </div>
    <div class="col-sm-3 footer-row visible hide-col">
        <div class="footer-col2">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
        <div class="point-holder">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
    </div>
</div>

<?php Pjax::begin(['enablePushState' => false]); ?>
<?php echo \app\widgets\News::widget(['data' => $news]); ?>
<?php Pjax::end(); ?>

<div class="row">
    <div class="col-sm-3 footer-row hide-col">
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
    </div>
    <div class="col-sm-6 footer-row footer-stroke-white">
        <div class="chapter"><a name="down4">О ФЕСТИВАЛЕ</a></div>
        <div class="slesh">////////////////////////////////////////////////////////////////////////////////////////////////////////////////////</div>
        <div></div>
    </div>
    <div class="col-sm-3 footer-row visible hide-col">
        <div class="footer-col2">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
        <div class="point-holder">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
    </div>
</div>

<div class="container marg">
    <div class="row marg">
        <div class="col-md-8 ofeste no-padding">
            <div class="text3"><?php echo \config\Config::getValue('about_text'); ?></div>
        </div>
        <div class="col-md-4 no-padding o-fester-logo">
            <div class="logo3"><img src="image/logo.png" alt=""></div>
        </div>
    </div>
</div>

<?php if (\config\Config::getValue('program_status') == 1): ?>
    <div class="row">
        <div class="col-sm-3 footer-row hide-col">
            <div class="footer-col">
                <div class="footer-point"></div>
            </div>
            <div class="footer-col">
                <div class="footer-point"></div>
            </div>
            <div class="footer-col">
                <div class="footer-point"></div>
            </div>
        </div>
        <div class="col-sm-6 footer-row footer-stroke-white">
            <div class="chapter"><a name="down5">ПРОГРАММА</a></div>
            <div class="slesh">////////////////////////////////////////////////////////////////////////////////////////////////////////////////////</div>
            <div></div>
        </div>
        <div class="col-sm-3 footer-row visible hide-col">
            <div class="footer-col2">
                <div class="footer-point2"></div>
                <div class="footer-point2"></div>
            </div>
            <div class="point-holder">
                <div class="footer-point2"></div>
                <div class="footer-point2"></div>
                <div class="footer-point2"></div>
                <div class="footer-point2"></div>
                <div class="footer-point2"></div>
                <div class="footer-point2"></div>
            </div>
        </div>
    </div>

    <div class="container marg">
        <div id="thirdCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
            <div class="col-md-12 pop-up2 carousel-inner" role="listbox">
                <div class="col-xs-2 no-padding prev-but" id="prev-but2">
                    <a class="slide-zone big-text2 left carousel-control" href="#thirdCarousel" role="button"
                       data-slide="prev"><</a>
                </div>
                <div class="col-xs-2 no-padding next-but" id="next-but2">
                    <a class="slide-zone big-text2 right carousel-control" href="#thirdCarousel" role="button"
                       data-slide="next">></a>
                </div>

                <?php $active = true; ?>
                <?php foreach ($programs as $day => $program): ?>
                    <div class="row marg item <?php echo $active ? 'active' : ''; ?>">
                        <div class="wrapper-head-carousel">
                            <div class="col-xs-2 visible no-padding">
                                <div class="button-point-holder left">
                                    <?php echo $this->render('_points', ['num' => 49]); ?>
                                    <div style="clear:left"></div>
                                </div>
                            </div>
                            <div class="col-xs-8 no-padding">
                                <div class="chapter-zone"><?php echo $day; ?>-Й ДЕНЬ</div>
                            </div>
                            <div class="col-xs-2 visible no-padding">
                                <div class="button-point-holder right">
                                    <?php echo $this->render('_points', ['num' => 49]); ?>
                                    <div style="clear:left"></div>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($program as $item): ?>
                            <div class="col-md-6 col-sm-12 marg">
                                <div class="col-sm-4 center-text">
                                    <div class=" zone-bar2 ">
                                        <?php echo Html::img($item->zone->getThumbFileUrl('image', 'normal')); ?>
                                    </div>
                                </div>
                                <div class="col-sm-8 center-pogram">
                                    <div class="big-text"><?php echo $item->time ?></div>
                                    <div class="text3 no-padding"><?php echo $item->name ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php $active = false; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    </div>
<?php endif; ?>

<?php echo \app\widgets\Lecturer::widget(); ?>

<?php echo \app\widgets\Participants::widget(); ?>

<div class="row">
    <div class="col-sm-3 footer-row hide-col">
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
    </div>
    <div class="col-sm-6 footer-row footer-stroke-white">
        <div class="chapter"><a name="down9">Фуд корт</a></div>
        <div class="slesh">////////////////////////////////////////////////////////////////////////////////////////////////////////////////////</div>
        <div></div>
    </div>
    <div class="col-sm-3 footer-row visible hide-col">
        <div class="footer-col2">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
        <div class="point-holder">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
    </div>
</div>

<div class="container marg">
    <div class="row marg">
        <div class="text3"><?php echo \config\Config::getValue('foodcourt_text'); ?></div>
        <div class="row marg">
            <?php foreach ($foodcourt as $item): ?>
            <div class="col-md-4 food-img">
                <?php echo Html::img($item->getThumbFileUrl('picture', 'normal')); ?>
                <div class="text3 center-text"><?php echo $item->title; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php echo \app\widgets\Map::widget(); ?>
<?php echo \app\widgets\Partners::widget(); ?>

<div class="row">
    <div class="col-sm-3 footer-row hide-col">
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
        <div class="footer-col">
            <div class="footer-point"></div>
        </div>
    </div>
    <div class="col-sm-6 footer-row footer-stroke">
        <div class="place text"><?php echo nl2br(\config\Config::getValue('city')); ?></div>
        <div class="footer-text"><?php echo nl2br(\config\Config::getValue('contacts')); ?></div>
    </div>
    <div class="col-sm-3 footer-row visible hide-col">
        <div class="footer-col2">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
        <div class="point-holder">
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
            <div class="footer-point2"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var currentTime = <?php echo $remainTime; ?>;
</script>