<?php

use Core\Routing\URL;
?>


<script>
    function deleteItem(id) {
        $.ajax({
            url: '<?= URL::link('personnel_api_delete_personnel'); ?>' + id,
            cache: true,
            type: 'post',
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {

                table.ajax.reload(null, false); // user paging is not reset on reload
                swal("Bingo !!!", "Suppression réalisée avec sucess !!!", 'success')

            },
            error: function(textStatus, errorThrown) {
                Success = false;
                swal("Erreur", "Erreur de communication avec le serveur :)", "error");
                console.log(textStatus, errorThrown);
            }
        });
    }

    // Must use FileSaver.js 2.0.2 because 2.0.3 has issues.
    function download(imagePath) {
        let fileName = getFileName(imagePath)
        console.log(fileName)
        console.log(imagePath)
        saveAs(imagePath, fileName)
    }

    function getFileName(str) {
        return str.substring(str.lastIndexOf('/') + 1)
    }
</script>

<script type="text/javascript">
    // Include this file AFTER both jQuery and bootstrap are loaded.
    $(document).ready(function(){

        $.fn.modal.Constructor.prototype.enforceFocus = function () {
            modal_this = this
            $(document).on('focusin.modal', function (e) {
                if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
                // add whatever conditions you need here:
                &&
                !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select') && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
                    modal_this.$element.focus()
                }
            })
        };

    });

    function open_modal(){
        $( '#modal_modele_message_create' ).modal( {
            focus: false
        } );
    }
</script>


<script>
    ClassicEditor
        .create(document.querySelector('.editor'), {
            mention: {
                feeds: [{
                    marker: '@',
                    feed: ['@Barney', '@Lily', '@Marshall', '@Robin', '@Ted'],
                    minimumCharacters: 0
                }]
            },

            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'outdent',
                    'indent',
                    '|',
                    'blockQuote',
                    'insertTable',
                    'undo',
                    'redo',
                    'alignment',
                    'underline',
                    'imageUpload',
                    'fontBackgroundColor',
                    'fontColor',
                    'fontFamily',
                    'fontSize',
                    'highlight',
                    'horizontalLine',
                    'imageInsert',
                    'pageBreak'
                ]
            },
            language: 'fr',
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            licenseKey: '',



        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
            console.warn('Build id: f6ww3k8z1mc6-jac2uaxlife2');
            console.error(error);
        });
</script>