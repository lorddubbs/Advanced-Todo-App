import { createLocalVue, shallowMount } from "@vue/test-utils";
import Vuex from 'vuex';
import CreateComment from "@/common/components/forms/CreateComment";

const localVue = createLocalVue();
localVue.use(Vuex);

describe("CreateComment", () => {
    
    let actions;
    let store;

    beforeEach(() => {

      actions = {
        createComment: jest.fn()
      }

      store = new Vuex.Store({
        modules: { 
         comment: {
           actions,
           namespaced: true
         }
        }
      })
    })

    it("sets all accurate data and simulates a submission", async () => {
        const taskId = 1;
        const wrapper = shallowMount(CreateComment, { store, localVue,
            propsData: {
              task: taskId
            }
          });
        // checks if the component name is accurate
        expect(wrapper.vm.$options.name).toMatch('CreateComment');
    
        expect(wrapper.setData({
            comment: 'Life is Beautiful'
          }));
          
          await wrapper.find('button').trigger('click');
          expect(actions.createComment).toHaveBeenCalled()
        });
      });
    
    