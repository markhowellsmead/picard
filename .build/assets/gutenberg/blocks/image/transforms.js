import { createBlock } from '@wordpress/blocks';

const blockName = 'mhm/image';

const transforms = {
    to: [
        {
            type: 'block',
            blocks: ['core/image'], // Block type TO which we can convert
            transform: attributes => {
                // What to do when converting
                return createBlock('core/heading', attributes);
            },
        },
    ],
    from: [
        {
            type: 'block',
            blocks: ['core/image'], // Block types FROM which we can convert
            transform: attributes => {
                // What to do when converting
                return createBlock(blockName, attributes);
            },
        },
    ],
};

export default transforms;
