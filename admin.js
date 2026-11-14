jQuery(document).ready(function($) {
    // This single function handles the media uploader for any button with the correct class
    $('body').on('click', '.maxsys-meta-upload-button', function(e) {
        e.preventDefault();

        const button = $(this);
        const targetInputId = button.data('target-id');
        const imageInput = $('#' + targetInputId);
        const imagePreviewContainer = imageInput.parent();

        const uploader = wp.media({
            title: 'Select a Social Sharing Image',
            button: { text: 'Use this image' },
            multiple: false
        }).on('select', function() {
            const attachment = uploader.state().get('selection').first().toJSON();
            imageInput.val(attachment.url);

            // Update or create the preview image
            let preview = imagePreviewContainer.next('p').find('img');
            if (preview.length) {
                preview.attr('src', attachment.url);
            } else {
                imageInput.parent().after('<p><img src="' + attachment.url + '" style="max-width: 200px; height: auto; margin-top:10px;"></p>');
            }
        }).open();
    });
});