import { _x } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { SelectControl, PanelBody, ServerSideRender } from '@wordpress/components';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';

registerBlockType('mhm/place-descendants', {
    title: _x('Place descendants', 'Block title', 'sha'),
    icon: 'layout',
    category: 'widgets',
    supports: {
        align: ['wide', 'full'],
        mode: false,
        html: false,
        multiple: false,
        reusable: false,
    },
    attributes: {
        place_type: {
            type: 'string',
            default: 'place',
        },
    },
    edit({ attributes, setAttributes }) {
        const { place_type } = attributes;
        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody title='Block options' initialOpen={true}>
                        <SelectControl
                            label='Select place type'
                            value={place_type}
                            options={[
                                { label: 'Country', value: 'country' },
                                { label: 'Region', value: 'region' },
                                { label: 'Place', value: 'place', isDefault: true },
                            ]}
                            onChange={value => {
                                setAttributes({ place_type: value });
                            }}
                        />
                    </PanelBody>
                </InspectorControls>
                <ServerSideRender block='mhm/place-descendants' attributes={attributes} />
            </Fragment>
        );
    },
    save() {
        return null;
    },
});
