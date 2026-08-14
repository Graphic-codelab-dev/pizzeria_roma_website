<?php
/**
 * Miembros del equipo. Para agregar/quitar personas, edita el array
 * $teamMembers: cada entrada necesita 'name' y 'role' ('photo' es
 * opcional — sin foto se muestra el placeholder circular).
 */
$teamMembers = [
    [
        'name'  => 'Rob',
        'role'  => t($t, 'about.team_role_owner'),
        'photo' => '/assets/images/about/rob.webp',
    ],
    [
        'name'  => "Rob's Dad",
        'role'  => t($t, 'about.team_role_co_owner'),
        'photo' => '/assets/images/about/rob_dad.webp',
    ],
    
    // ['name' => 'Nombre Apellido', 'role' => 'Cargo', 'photo' => '/assets/images/about/foto.webp'],
];
?>
<section class="about-team u-section" data-reveal>
  <div class="u-container u-text-center">
    <span class="u-eyebrow"><?= htmlspecialchars(t($t, 'about.team_eyebrow')) ?></span>
    <h2><?= htmlspecialchars(t($t, 'about.team_title')) ?></h2>
    <p class="about-team__body"><?= htmlspecialchars(t($t, 'about.team_body')) ?></p>

    <ul class="about-team__grid">
      <?php foreach ($teamMembers as $member): ?>
      <li class="about-team__member">
        <?php if (!empty($member['photo'])): ?>
        <img class="about-team__photo" src="<?= htmlspecialchars($member['photo']) ?>"
             alt="<?= htmlspecialchars($member['name']) ?>"
             width="220" height="220" loading="lazy" decoding="async">
        <?php else: ?>
        <div class="about-team__media-placeholder" aria-hidden="true"></div>
        <?php endif; ?>
        <p class="about-team__name"><?= htmlspecialchars($member['name']) ?></p>
        <p class="about-team__role"><?= htmlspecialchars($member['role']) ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
