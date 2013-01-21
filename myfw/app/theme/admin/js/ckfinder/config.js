CKFinder.customConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.skin = 'v1';
	// config.language = 'fr';
    config.removePlugins = 'basket';
    config.connectorUrl  = ADMIN_URL + '/ckfinder/connect';
};
