<!-- Enquiry listing view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div>

<?= $results; ?>

<?= form_open('promotions/add_promotion_input');?>
<input type="submit" name="submit" value="Add a promotion" />
</form>
</div>
