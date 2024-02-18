<div class="skills-card skill-card">
    <div><?php echo $skillName; ?></div>
    <div class="level-bar-container">
        <div>
            <div class="level-bar">
            </div>
            <div id="level-bar-<?php echo $skillName; ?>"></div>
        </div>
        <p class="level-rating"><?php echo $skillLevel; ?>/5</p>
        <div class="skill-comment">Comment: <?php echo $comment; ?></div>
    </div>
<div>

<script>
// Select the level-bar element using a unique id for each row
var l = document.getElementById("level-bar-<?php echo $skillName; ?>");

l.style.width = "<?php echo 50 * $skillLevel ?>px";
l.style.height = "10px";

</script>
