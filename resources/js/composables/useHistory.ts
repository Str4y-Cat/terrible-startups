import { ref } from 'vue';

//global position counter
const position = ref(1);

export function useHistory() {
    //go forward in history
    function goForward() {
        window.history.forward();
        // position.value++;
    }

    //go back in history
    function goBack() {
        window.history.back();

        //work around the inertia auto incrementation
        position.value--;
        position.value--;
    }

    // increment when navigation happens
    function trackNavigation() {
        position.value++;
    }

    function canGoForward() {
        console.log('can go forward', position.value, window.history.length);
        // console.log()
        return position.value != window.history.length;
    }
    function canGoBack() {
        // console.log('can go back', position.value > 1);
        return position.value > 0;
    }

    return {
        canGoForward,
        canGoBack,
        position,
        goForward,
        goBack,
        trackNavigation,
    };
}
