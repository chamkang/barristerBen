<?php
/**
 * Settings for the article editor (/admin) on the live server.
 *
 * DO NOT put real values in this example or commit them anywhere. Instead:
 *   1. In cPanel > File Manager, open your HOME folder (the one that CONTAINS
 *      the fonjulawfirm.com folder, not the fonjulawfirm.com folder itself).
 *   2. Create a file named  fonju-admin-config.php  there and paste this in.
 *   3. Fill in the four values and save. Permissions: 0600 or 0640.
 *
 * Because it sits outside the website folder it can never be downloaded, and
 * deployments never touch it. (If your host does not allow that, the editor
 * also looks for storage/admin-config.php inside the site, which is blocked
 * from the web.)
 */
return [
    // The password the lawyer types at https://fonjulawfirm.com/admin
    // (long is better than complicated: four or five random words work well).
    'ADMIN_PASSWORD' => '',

    // 64 random characters. Changing it signs everyone out of the editor.
    // Generate one at the command line with:  openssl rand -hex 32
    'SESSION_SECRET' => '',

    // GitHub > Settings > Developer settings > Fine-grained tokens.
    // Repository access: only chamkang/barristerBen.
    // Permissions: Contents = Read and write; Actions = Read (optional).
    'GITHUB_TOKEN'   => '',

    'GITHUB_REPO'    => 'chamkang/barristerBen',
    'GITHUB_BRANCH'  => 'main',
];
