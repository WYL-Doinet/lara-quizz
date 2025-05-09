
import { AxiosInstance } from "axios";
import ziggyRoute, { Config as ZiggyConfig } from "ziggy-js";

export {};

declare global {
    interface Window {
        axios: AxiosInstance;
    }

    var route: typeof ziggyRoute;
    var Ziggy: ZiggyConfig;
}

interface InertiaAppProps {
    flash: {
        success: string;
        error: string;
    };
}

declare module "@inertiajs/core" {
    interface PageProps extends InertiaAppProps {}
}

declare module "vue" {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}


