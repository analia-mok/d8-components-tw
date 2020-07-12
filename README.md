# Drupal 8 Components - TailwindCSS

An experiement exploring the use of TailwindCSS in Drupal 8 theming.

## Installation instructions (incomplete)

1. Have [Lando](https://docs.lando.dev/basics/installation.html) version 3.0.1+ installed
2. Run `lando start`
3. Install Drupal
4. (At the moment) If you want all of the configuration in this project, you may need to delete some
common configurations, such as `block.block.bartik_account_menu.yml` due to UUID mismatching.
  * This project (currently) only contains two block types, each with various view modes:
    * CTA -- Simple
    * Hero Section
  * This project also defines new layout options via the `tailwindcss_layouts` module.
