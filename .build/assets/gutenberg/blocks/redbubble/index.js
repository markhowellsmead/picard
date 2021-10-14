import { _x } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { ServerSideRender } from '@wordpress/components';

registerBlockType('mhm/redbubble', {
    title: _x('Redbubble', 'Block title', 'sha'),
    icon: 'image-flip-horizontal',
    category: 'widgets',
    supports: {
        mode: false,
        html: false,
        multiple: false,
        reusable: true,
    },
    edit: () => {
        return <ServerSideRender block='mhm/redbubble' />;
    },
    save() {
        return null;
    },
});
