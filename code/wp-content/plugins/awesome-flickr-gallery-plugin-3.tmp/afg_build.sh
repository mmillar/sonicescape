# Build a zip file for current version of the plugin. Takes version number as argument for zipfile name.
branch=`git branch | grep \*`
branch=${branch:2}
echo $branch
zip -r awesome-flickr-gallery-plugin.zip . -x \*.git\* -x \*timthumb.txt\* -x \*.svn\*
