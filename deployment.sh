#!/bin/bash

echo "Running deployment script..."
echo "Please note that all  contents from public_html will be deleted."

rm -rf public_html
svn checkout http://sfsuswe.com/svn/f15g11/trunk

mv trunk public_html
rm -rf public_html/.svn

