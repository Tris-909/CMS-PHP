// WYSIWYG Editor to add more beautiful text area into your posts
ClassicEditor
.create( document.querySelector( '#body' ) )
.catch( error => {
    console.error( error );
} );

//  Checkbox in view_all_post
$(document).ready(function(){
    $('#selectAllPost').click(function() {
        if (this.checked) {
            $('.checkBoxes').each(function() {
                this.checked = true;
            });
        } else {
            $('.checkBoxes').each(function() {
                this.checked = false;
            });
        }
    });
});