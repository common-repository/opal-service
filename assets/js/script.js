jQuery(document).ready(function($) {
    $(document).ready(function() {
        if( $(".owl-carousel-play").length > 0 ){
            /**
             *
             * Automatic apply  OWL carousel
             */
            $(".owl-carousel-play .owl-carousel").each( function(){
                var config = {
                    navigation : false, // Show next and prev buttons
                    slideSpeed : 300,
                    paginationSpeed : 400,
                    pagination : $(this).data( 'pagination' ),
                    autoHeight: true
                    //afterAction: afterAction
                };

                var owl = $(this);
                if( $(this).data('slide') == 1 ){
                    config.singleItem = true;
                }else {
                    config.items = $(this).data( 'slide' );
                }
                if ($(this).data('desktop')) {
                    config.itemsDesktop = $(this).data('desktop');
                }
                if ($(this).data('desktopsmall')) {
                    config.itemsDesktopSmall = $(this).data('desktopsmall');
                }
                if ($(this).data('desktopsmall')) {
                    config.itemsTablet = $(this).data('tablet');
                }
                if ($(this).data('tabletsmall')) {
                    config.itemsTabletSmall = $(this).data('tabletsmall');
                }
                if ($(this).data('mobile')) {
                    config.itemsMobile = $(this).data('mobile');
                }
                if ( $('.pbr-owl-thumbs li', $(this).parent()).length > 0) {
                    config.afterAction = function() {
                        $('.pbr-owl-thumbs li').removeClass('active');
                        $('.pbr-owl-thumbs li').eq(this.owl.currentItem).addClass('active');
                    };
                }
                $(this).owlCarousel( config );
                $('.left',$(this).parent()).on('click', function(){
                    owl.trigger('owl.prev');
                    return false;
                });
                $('.right',$(this).parent()).on('click', function(){
                    owl.trigger('owl.next');
                    return false;
                });
                $('.thumbs li', $(this)).on('click', function(){
                    owl.trigger('owl.next');
                    return false;
                });
                $('.pbr-owl-thumbs li', $(this).parent()).on('click', function(){
                    var index = $(this).index();
                    owl.trigger('owl.goTo', index);
                    $('.pbr-owl-thumbs li').removeClass('active');
                    $(this).addClass('active');
                    return false;
                });
                //owl.config.afterAction =

            } );
        }

        var $service_slick = $('.elementor-service-slick-slider');
        var slideCount = null;

        $service_slick.on('init', function(event, slick){
            slideCount = slick.slideCount;
            setCurrentSlideNumber(slick.currentSlide);
        });

        $service_slick.on('beforeChange', function(event, slick, currentSlide, nextSlide){
            setCurrentSlideNumber(nextSlide);
        });

        function setCurrentSlideNumber(currentSlide) {
            var $el = $('.slick-pagination-custom').find('.filled');
            width = ( (currentSlide + 1) / slideCount) * 100;
            $el.attr('style', 'width:' + width + '%');
        }

        // $service_slick.each( function(i, el){
        //
        //     var $this = $(el),
        //         //Setters
        //         setSlidesToShow = $this.data('slides-show'),
        //         setSlidesToScroll = $this.data('slides-scroll'),
        //         setDot = $this.data('pagination'),
        //         setAutoplay = $this.data('autoplay'),
        //         setAnimation = $this.data('animation'),
        //         setEasing = $this.data('easing'),
        //         setFade = $this.data('fade'),
        //         setSpeed = $this.data('speed'),
        //         setSlidesRows = $this.data('rows'),
        //         setCenterMode = $this.data('center-mode'),
        //         setCenterPadding = $this.data('center-padding'),
        //         setPauseOnHover = $this.data('pause-hover'),
        //         setVariableWidth = $this.data('variable-width'),
        //         setVertical = $this.data('vertical'),
        //         setRtl = $this.data('rtl'),
        //         setFocusOnSelect = $this.data('focus-on-select'),
        //         setLazyLoad = $this.data('lazy-load'),
        //         setTabletColumns = $this.data('table-columns'),
        //         setMobileColumns = $this.data('mobile-columns')

            // $this.slick({
            //
            //     autoplay: setAutoplay ? true : false,
            //     autoplaySpeed: setSpeed ? setSpeed : 3000,
            //
            //     cssEase: setAnimation ? setAnimation : 'ease',
            //     easing: setEasing ? setEasing : 'linear',
            //     fade: setFade ? true : false,
            //
            //     infinite:  true ,
            //     slidesToShow: setSlidesToShow ? setSlidesToShow : 3,
            //     slidesToScroll: setSlidesToScroll ? setSlidesToScroll : 1,
            //     centerMode: setCenterMode ? true : false,
            //     variableWidth: setVariableWidth ? true : false,
            //     pauseOnHover: setPauseOnHover ? true : false,
            //     rows: setSlidesRows ? setSlidesRows : 1,
            //     vertical: setVertical ? true : false,
            //     verticalSwiping: setVertical ? true : false,
            //     rtl: setRtl ? true : false,
            //     centerPadding: setCenterPadding ? setCenterPadding : 0,
            //     focusOnSelect: setFocusOnSelect ? true : false,
            //     lazyLoad: setLazyLoad ? setLazyLoad : true,
            //     dots: setDot ? true : false,
            //     adaptiveHeight: true,
            //     responsive: [
            //         {
            //             breakpoint: 1023,
            //             settings: {
            //                 slidesToShow: setTabletColumns ? setTabletColumns : 2 ,
            //                 infinite: true,
            //             }
            //         },
            //         {
            //             breakpoint: 767,
            //             settings: {
            //                 slidesToShow: setMobileColumns ? setMobileColumns : 1 ,
            //             }
            //         },
            //     ]
            // });
        // });
        // if ( window.elementorFrontend ) {
        //
        //   elementorFrontend.hooks.addAction('frontend/element_ready/opal-servicecarousel.default', ($scope) => {
        //
        //     if( $scope.find(".elementor-service-slick-slider").length > 0 ){
        //         var $service_slick = $('.elementor-service-slick-slider');
        //         $service_slick.on('afterChange', function(event, slick, currentSlide, nextSlide){
        //           slideCount = slick.slideCount;
        //           var $el = $('.slick-pagination-custom').find('.filled');
        //           width = ( (currentSlide + 1) / slideCount) * 100;
        //           $el.attr('style', 'width:' + width + '%');
        //         });
        //
        //         $service_slick.each( function(i, el){
        //             var $this = $(el),
        //             //Setters
        //             setSlidesToShow = $this.data('slides-show'),
        //             setSlidesToScroll = $this.data('slides-scroll'),
        //             setDot = $this.data('pagination'),
        //             setAutoplay = $this.data('autoplay'),
        //             setAnimation = $this.data('animation'),
        //             setEasing = $this.data('easing'),
        //             setFade = $this.data('fade'),
        //             setSpeed = $this.data('speed'),
        //             setSlidesRows = $this.data('rows'),
        //             setCenterMode = $this.data('center-mode'),
        //             setCenterPadding = $this.data('center-padding'),
        //             setPauseOnHover = $this.data('pause-hover'),
        //             setVariableWidth = $this.data('variable-width'),
        //             setVertical = $this.data('vertical'),
        //             setRtl = $this.data('rtl'),
        //             setFocusOnSelect = $this.data('focus-on-select'),
        //             setLazyLoad = $this.data('lazy-load'),
        //             setTabletColumns = $this.data('table-columns'),
        //             setMobileColumns = $this.data('mobile-columns')
        //
        //             $this.slick({
        //
        //               autoplay: setAutoplay ? true : false,
        //               autoplaySpeed: setSpeed ? setSpeed : 3000,
        //
        //               cssEase: setAnimation ? setAnimation : 'ease',
        //               easing: setEasing ? setEasing : 'linear',
        //               fade: setFade ? true : false,
        //
        //               infinite:  true ,
        //               slidesToShow: setSlidesToShow ? setSlidesToShow : 3,
        //               slidesToScroll: setSlidesToScroll ? setSlidesToScroll : 1,
        //               centerMode: setCenterMode ? true : false,
        //               variableWidth: setVariableWidth ? true : false,
        //               pauseOnHover: setPauseOnHover ? true : false,
        //               rows: setSlidesRows ? setSlidesRows : 1,
        //               vertical: setVertical ? true : false,
        //               verticalSwiping: setVertical ? true : false,
        //               rtl: setRtl ? true : false,
        //               centerPadding: setCenterPadding ? setCenterPadding : 0,
        //               focusOnSelect: setFocusOnSelect ? true : false,
        //               lazyLoad: setLazyLoad ? setLazyLoad : true,
        //
        //               dots: setDot ? true : false,
        //               adaptiveHeight: true,
        //               responsive: [
        //                 {
        //                   breakpoint: 1023,
        //                   settings: {
        //                   slidesToShow: setTabletColumns ? setTabletColumns : 2 ,
        //                   infinite: true,
        //                   }
        //                 },
        //                 {
        //                   breakpoint: 767,
        //                   settings: {
        //                   slidesToShow: setMobileColumns ? setMobileColumns : 1 ,
        //                   }
        //                 },
        //               ]
        //           });
        //
        //         });
        //       }
        //      // carouselFuncs( $scope );
        //   });
        // }
    });

});
