<?php
/**
 * Google Map, loaded only with consent. Google sets its own cookies when the
 * map loads, so the iframe is created by the consent manager in main.js once
 * the visitor accepts "Maps & embedded content" (or presses the button here,
 * which records that consent). Without JavaScript, a plain link is shown.
 */
$mapEmbed = 'https://www.google.com/maps?q=' . CONTACT['map_query'] . '&output=embed';
$mapLink  = 'https://www.google.com/maps/search/?api=1&query=' . CONTACT['map_query'];
?>
<div class="map-frame map-frame--consent reveal"
     data-consent-embed="media"
     data-embed-src="<?= e($mapEmbed) ?>"
     data-embed-title="<?= e(t('Map showing the location of Fonju Law Firm in Akwa, Douala')) ?>">
  <div class="map-consent">
    <span class="map-consent__icon"><?= icon('pin', 30) ?></span>
    <p class="map-consent__title"><?= e(contact('street')) ?>, <?= e(contact('city')) ?></p>
    <p class="map-consent__text"><?= e(t('The map is provided by Google, which may set cookies when it loads.')) ?></p>
    <div class="map-consent__actions">
      <button class="btn btn--gold btn--sm" type="button" data-consent-load="media"><?= e(t('Show the map')) ?></button>
      <a class="btn btn--outline btn--sm" href="<?= e($mapLink) ?>" target="_blank" rel="noopener"><?= e(t('Open in Google Maps')) ?></a>
    </div>
  </div>
</div>
