// Main App Funcs
(function($) {
    "use strict";

    const   windowEl = window, 
            bodyEl = document.body,
            wpMetaBox = $( '.postbox' ),
            galleryCont = wpMetaBox.find('.fpf-gallery-eles'),
            thumbsWrapStr = '.fpf-gallery-ele',
            galleryUploadBtn = wpMetaBox.find('.gallery-upload'),
            galleryHiddenInput = wpMetaBox.find('#fpf-gallery-id-field'),
            imgToBg = function(el){
                el.each(function(){
                    let img = $(this).find('img'),
                        imgUrl = img.attr('src');

                    $(this).css({
                        'backgroundImage': 'url('+imgUrl+')'
                    });
                });
            };


    const app = {        

        init : function() { 
            app.displayMetaBox();                        
            app.galleryFn();
            app.thumbsAsBg();                
        },        
        displayMetaBox : function(){   
            let postFormat = fpf_vars.post_format,
                filterPostFormatMetabox = function(){
                    let filteredEl = wpMetaBox.filter(function(){
                        return $(this).attr('id') === 'fpf-' + postFormat + '_metabox';
                    });

                    if( filteredEl.length > 0 ) {
                        filteredEl.addClass('active').siblings().removeClass('active');
                    } else {
                        wpMetaBox.removeClass('active');
                    }
                }         
            
            filterPostFormatMetabox();

            $(document).on('change', '.editor-post-format select', function(){
                postFormat = $(this).find('option:selected').val();
                filterPostFormatMetabox();
            });

            $(document).on('click', '#post-formats-select .post-format', function(){
                postFormat = $(this).val();
                filterPostFormatMetabox();
            });
        },        
        galleryFn:function(){
            let mediaUploader,
                thumbnailCont,
                selectionModelId,
                galleryImagesId = [],
                newGalleryImgsIds,
                filteredInputValuesArray = function(){
                    let currentInputValuesArray = [],
                        filteredArray;

                    $(thumbsWrapStr).filter(':visible').each(function(){
                        let parentId = $(this).data('img-id');

                        currentInputValuesArray.push(parentId);
                    });    
                    
                    filteredArray = currentInputValuesArray; 

                    return filteredArray;
                };           

            galleryUploadBtn.on('click',function(e){
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select or upload your gallery image(s)',
                    library: {
                        type: 'image'
                    },
                    button: {
                        text: 'Use gallery image(s)'
                    },
                    multiple: true
                });

                mediaUploader.on('select', function(){

                    let selectionsModels = mediaUploader.state().get('selection').models;

                    selectionsModels.map(function(selectionsModel){
                        let selectionModelUrl = selectionsModel.attributes.url;

                        selectionModelId = selectionsModel.attributes.id;                            

                        if( selectionsModel.attributes.sizes !== undefined && selectionsModel.attributes.sizes.thumbnail !== undefined ) {
                            selectionModelUrl = selectionsModel.attributes.sizes.thumbnail.url;
                        }  
                        
                       // galleryImagesId.push(selectionModelId);  

                        galleryCont.append('<div class="fpf-gallery-ele" data-img-id="' + selectionModelId+ '"><img src="' + selectionModelUrl + '"/><span class="remove-img">x</span></div>');

                        thumbnailCont = $(thumbsWrapStr);

                        imgToBg(thumbnailCont);

                        mediaUploader.trigger('update');                      
                    }); 
                });

                mediaUploader.on('update', function(){ 
                    let updatedIds = [],
                        filteredNewArray;

                    $(thumbsWrapStr).filter(':visible').each(function(){                        
                        updatedIds.push($(this).data('img-id'));
                    });

                    updatedIds.concat(galleryImagesId);

                    newGalleryImgsIds = updatedIds;

                    filteredNewArray = newGalleryImgsIds.filter(function(newGalleryid){
                        // targets elements that are not empty("") especially the first time you switch to gallery post format.
                        return newGalleryid.length !== 0;
                    });
                              
                    galleryHiddenInput.val(filteredNewArray.join());

                });

                mediaUploader.open();              
            });

            $(document).on('click','.remove-img',function(){

                $(this).parent().fadeOut(200, function(){
                    galleryHiddenInput.val(filteredInputValuesArray().join());
                    $(this).remove();
                });
                
            });

            galleryCont.sortable({
                stop: function () { 
                    galleryHiddenInput.val(filteredInputValuesArray().join());
                }
            });

            $(window).on('load',function(){
                galleryHiddenInput.val(filteredInputValuesArray().join());
            });


        },
        thumbsAsBg : function(){
            imgToBg($(thumbsWrapStr));
        }

    }

    document.addEventListener('DOMContentLoaded', function () {
        app.init();
    });

})(jQuery);
