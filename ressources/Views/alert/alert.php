
<?php
    use App\Helpers\S;
?>

<script type="text/javascript">
<?php
    if($this->session->has(S::FLASH_TAG)){
        echo 'toastr. '.$this->session->get(S::FLASH_TAG, S::FLASH_TYPE).'("'.$this->session->get(S::FLASH_TAG, S::FLASH_MESSAGE).'", { "showMethod": "slideDown", "hideMethod": "slideUp", "hideDuration": 3000, "closeButton": true });';
        $this->session->flush(S::FLASH_TAG);
    }
?>
</script>