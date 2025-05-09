export const useDebounce = () => {
    let timeout: any;

    return (cb: CallableFunction, delay: number) => {

        if (timeout) {
            clearTimeout(timeout)
        }

        timeout = setTimeout(() => {
            cb()
        }, delay)
    }
}