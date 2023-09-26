
$(function (){ 

    'use strict';

    // Switch Between Login & Signup

    $('.login-page h1 span').click(function(){

        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        $('.' + $(this).data('class')).fadeIn('100');

    });

    // Tirgger The SelectBoxit

    // $("select").selectBoxIt({
    //     autoWidth: false
    // });

    // Hide Placeholder On From Foucs

    $('[placeholder]').focus(function (){

        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placeholder', '');

    }).blur(function(){

        $(this).attr('placeholder', $(this).attr('data-text'));
        
    });

    // Add Asterisk On Required Field

    $('input').each(function(){
        if($(this).attr('required') == 'required'){
            $(this).after('<span class="asterisk">*</span>');
        }
    });

    // Convert Password Field To Text Field On Hover

    var passField = $('.password');
    $('.show-pass').hover(function(){

        passField.attr('type', 'text');

    }, function(){

        passField.attr('type', 'password');

    });

    // Confirmation Message On Button

    $('.confirm').click(function(){

        return confirm('Are You Sure?');
        
    });

    $('.live').keyup(function (){

        $($(this).data('class')).text($(this).val());

    });

    // Category View Option

    $('.cat h3').click(function (){

        $(this).next('.full-view').fadeToggle(200);

    });

    // (function() {
	
    //     function Slideshow( element ) {
    //         this.el = document.querySelector( element );
    //         this.init();
    //     }
        
    //     Slideshow.prototype = {
    //         init: function() {
    //             this.wrapper = this.el.querySelector( ".slider-wrapper" );
    //             this.slides = this.el.querySelectorAll( ".slide" );
    //             this.previous = this.el.querySelector( ".slider-previous" );
    //             this.next = this.el.querySelector( ".slider-next" );
    //             this.index = 0;
    //             this.total = this.slides.length;
    //             this.timer = null;
                
    //             this.action();
    //             this.stopStart();	
    //         },
    //         _slideTo: function( slide ) {
    //             var currentSlide = this.slides[slide];
    //             currentSlide.style.opacity = 1;
                
    //             for( var i = 0; i < this.slides.length; i++ ) {
    //                 var slide = this.slides[i];
    //                 if( slide !== currentSlide ) {
    //                     slide.style.opacity = 0;
    //                 }
    //             }
    //         },
    //         action: function() {
    //             var self = this;
    //             self.timer = setInterval(function() {
    //                 self.index++;
    //                 if( self.index == self.slides.length ) {
    //                     self.index = 0;
    //                 }
    //                 self._slideTo( self.index );
                    
    //             }, 3000);
    //         },
    //         stopStart: function() {
    //             var self = this;
    //             self.el.addEventListener( "mouseover", function() {
    //                 clearInterval( self.timer );
    //                 self.timer = null;
                    
    //             }, false);
    //             self.el.addEventListener( "mouseout", function() {
    //                 self.action();
                    
    //             }, false);
    //         }
            
            
    //     };
        
    //     document.addEventListener( "DOMContentLoaded", function() {
            
    //         var slider = new Slideshow( "#main-slider" );
            
    //     });
        
        
    // })();
    

});