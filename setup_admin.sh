#!/bin/bash
# Create admin user for Ruaya Space using MySQL
# Database: Ruaya_space
# Email: admin@ruaya.space  
# Password: admin123

mysql -h 127.0.0.1 -u root -p'' Ruaya_space < create_admin_user.sql
