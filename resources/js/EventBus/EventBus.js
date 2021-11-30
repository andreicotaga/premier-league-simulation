import Vue from "vue";

const EventBus = new class extends Vue {
    $emit(event, ...args) {
        super.$emit(event, ...args);
    }
}

export default EventBus;
