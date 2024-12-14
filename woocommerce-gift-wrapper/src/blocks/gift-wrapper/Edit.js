import ServerSideRender from '@wordpress/server-side-render';
import {useBlockProps} from '@wordpress/block-editor';
import {Disabled} from '@wordpress/components';

const Edit = () => {
    const blockProps = useBlockProps();

    return (
        <div {...blockProps} >
            <Disabled>
                <ServerSideRender block={'wcgw/gift-wrapper'} />
            </Disabled>
        </div>
    )
}

export default Edit
