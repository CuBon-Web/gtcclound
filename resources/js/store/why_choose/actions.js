import { HTTP } from '../../core/plugins/http'

export const addWhyChoose = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/why-choose-us/create', opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};

export const listWhyChoose = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/why-choose-us/list', opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};

export const detailWhyChoose = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/why-choose-us/edit/' + opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};

export const deleteWhyChoose = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/why-choose-us/delete/' + opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};
