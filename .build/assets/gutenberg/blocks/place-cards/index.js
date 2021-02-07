import { _x } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { ServerSideRender } from '@wordpress/components';
import { Component } from '@wordpress/element';

registerBlockType('mhm/place-cards', {
    title: _x('Places as cards', 'Block title', 'sha'),
    icon: 'image-flip-horizontal',
    category: 'widgets',
    supports: {
        align: ['wide', 'full'],
        mode: false,
        html: false,
        multiple: true,
        reusable: true,
    },
    keywords: ['cards', 'posts', 'place'],
    edit: class extends Component {
        render() {
            return <ServerSideRender block='mhm/place-cards' />;
        }
    },
    save() {
        return null;
    },
});
