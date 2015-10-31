#!/bin/bash

echo "Running deployment script..."
echo "Please note that all  contents from public_html will be deleted."

rm -rf public_html
svn export --username f15g11 --password CSC648team11  --non-interactive  http://sfsuswe.com/svn/f15g11/trunk public_html


