import metadata from './block.json';
import { registerBlockType, unregisterBlockType, getBlockTypes, getBlockType } from '@wordpress/blocks';
import { GiftWrapperIcon } from '../../js/helpers/Icons';
import domReady from '@wordpress/dom-ready'
import Edit from './Edit';
import './style.scss';

domReady(()=>{
    const allowedBlocks = getBlockTypes().map((block) => block.name);
    const existingConfig = getBlockType('wcgw/gift-wrapper');
    
    unregisterBlockType('wcgw/gift-wrapper');
    registerBlockType('wcgw/gift-wrapper', {
        ...existingConfig,
        parent: allowedBlocks
    });
})

registerBlockType(metadata.name, {
    ...metadata,
    icon: <GiftWrapperIcon />,
    edit: (props) => <Edit />
});
