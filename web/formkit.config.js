import { generateClasses } from "@formkit/themes";
import formkitTheme from "@/formkit.theme.js";

export default {
    config: {
        classes: generateClasses(formkitTheme),
    },
};
