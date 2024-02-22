<div class="skill-card">
    <div class="skill-name-container"><?php echo $skillName; ?></div>
    <div class="level-bar-container">
        <div>
            <div class="level-bar">
            </div>
            <div id="level-bar-<?php echo $skillName; ?>" class="skill-level-bar"></div>
        </div>
        <p class="level-rating"><?php echo $skillLevel; ?>/5</p>
        <div class="skill-comment">Comment: <?php echo $comment; ?></div>
    </div>
</div>

<script>
// Select the level-bar element using a unique id for each row
var l = document.getElementById("level-bar-<?php echo $skillName; ?>");

l.style.width = "<?php echo 20 * $skillLevel ?>%";
l.style.height = "10px";

</script>
