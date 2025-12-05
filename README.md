# Contact-Form-Plugin

![Version](https://img.shields.io/badge/version-1.0-blue)
![WordPress](https://img.shields.io/badge/wordpress-5.x+-green)
![License](https://img.shields.io/badge/license-GPLv2-blue)

**Author:** Ayon Biswas  
**Description:** A simple WordPress plugin to create contact forms, store submissions as Custom Post Types (CPT), and manage them in the WordPress dashboard.

---

## Features

- Create contact forms via shortcode.  
- Store submissions as a Custom Post Type (`cfp_submission`).  
- Nonce security and form validation included.  
- Easy to style using the included CSS file (`assets/frontend.css`).  

---

## Installation

1. Upload the `contact-form-pro` folder to the `/wp-content/plugins/` directory.  
2. Activate the plugin through the **Plugins** menu in WordPress.  
3. Use the shortcode in any page or post to display the contact form.  

---

## Usage

### Shortcode

Use the `[cfp_form]` shortcode to display the contact form:

```php
[cfp_form id="123"]
