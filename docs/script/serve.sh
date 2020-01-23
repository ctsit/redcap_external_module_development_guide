# To override variables in _config.yml for use in your local environment, 
# set those variables in _config_local.yaml. E.g. add a line like this to 
# link to the root of the develop branch of the CTSIT fork:
#
#   repo_root: https://github.com/ctsit/redcap_external_module_development_guide/tree/develop
#
# This script will load the contents of _config_local.yaml last if it exists.
# Github will only reference _config.yaml when building the site.

# Note: You might need to tell rvm which ruby to use before running this script.  e.g.
#
#   rvm use 2.6.3
#

bundle exec jekyll serve --config _config.yml,_config_local.yaml
