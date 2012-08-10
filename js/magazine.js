/**
 * a2f Magazine js
 *
 */
 
 $(document).ready(function() {
     
     /* HOMEPAGE */
     
     $('.home-wrapper #main .post').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
     );
     $('.home-wrapper #main .post').click(function() {
        var link = $('h3 a', this).attr('href');
        window.location.href = link; 
     });

     if (typeof _gaq != 'undefined') {
         // track clicks (big banner link)
         $('#gp-banner-gallery a').click(function() {
             _gaq.push(['_trackEvent', 'Banner', 'BIG', $(this).attr('href')]);
/*             console.log(['_trackEvent', 'Banner', 'BIG', $(this).attr('href')]); 
             return false;*/
         });
         $('#gp-banner-thumbs a').click(function() {
              _gaq.push(['_trackEvent', 'Banner', 'thumb', $(this).attr('href')]);
/*              console.log(['_trackEvent', 'Banner', 'thumb', $(this).attr('href')]); 
              return false;*/
         });
     }
     
     
     /* CATEGORIES / ARCHIVES */
     
     $('.archive-wrapper .post').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
     );
     $('.archive-wrapper .post').click(function() {
        var link = $('h3 a', this).attr('href');
        window.location.href = link; 
     });
     
     /* GALLERY */

     $('span.button').click(function() {
         $('#main .main.post').hide();
         $('#galleria-wrapper').show();
         
         var content = $(this).text();
         $('#galleria-wrapper h2').text('Photos from ' + content);

         var id = $(this).attr('id');
         id = id.substring(4);           // don't care about the "set-" prefix
     
         // Initialize Galleria
         $('#galleria').galleria({
             flickr: 'set:' + id,
             flickrOptions: {
                 sort: 'date-taken-asc',
                 thumbSize: 'small',
                 max: 100
             }
         });
         
         // track clicks (button)
         if (typeof _gaq != 'undefined') {
             _gaq.push(['_trackEvent', 'Photo Gallery', 'Button', id]);
         }

         $('html, body').animate({ scrollTop: 0 }, 300);     // scroll up
     });
     
     $('a.goback').click(function() {
         $('#galleria-wrapper').hide();
         $('#main .main.post').show();

         $('html, body').animate({ scrollTop: 0 }, 300);    // scroll up
     });
     
     $("#msgform").validate();
     
 });