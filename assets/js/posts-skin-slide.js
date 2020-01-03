( function( $ ) {
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/posts.slide', function( $scope ) {

            var slidesPostsContainer = $( $scope ).find( '.swiper-container' );
            if ( slidesPostsContainer ) {
                var postsSwiper = new Swiper ( slidesPostsContainer, {
                    loop: false,
                    slidesPerView: slidesToShow = $scope.data().settings.slide_columns,
                    spaceBetween: 20,
                    pagination: {
                      el: '.swiper-pagination',
                    },
                    navigation: {
                        nextEl: $( $scope ).find( '.swiper-button-next' ),
                        prevEl: $( $scope ).find( '.swiper-button-prev' ),
                    },
                    breakpoints: {
                        1024: {
                            slidesPerView: $scope.data().settings.slide_columns_tablet
                        },
                        767: {
                            slidesPerView: $scope.data().settings.slide_columns_mobile
                        }
                    }
                } );
            }
        } );
    } );
} )( jQuery );