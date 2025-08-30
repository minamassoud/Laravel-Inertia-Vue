import {library} from '@fortawesome/fontawesome-svg-core'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'

// Import the icons you want
import {
    faAngleDown,
    faCircleHalfStroke,
    faEnvelope,
    faIdBadge,
    faKey,
    faTriangleExclamation
} from '@fortawesome/free-solid-svg-icons'

// Add them to the library
library.add(
    faCircleHalfStroke,
    faIdBadge,
    faKey,
    faEnvelope,
    faAngleDown,
    faTriangleExclamation
)

// Export the component so it can be registered globally
export {FontAwesomeIcon}
