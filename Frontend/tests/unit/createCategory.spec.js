import { createLocalVue, shallowMount } from "@vue/test-utils";
import Vuex from 'vuex';
import CreateCategory from "@/common/components/forms/CreateCategory";

const localVue = createLocalVue();
localVue.use(Vuex);

describe("CreateCategory", () => {
    
    let actions;
    let store;

    beforeEach(() => {

      actions = {
        createCategory: jest.fn()
      }

      store = new Vuex.Store({
        modules: { 
         category: {
           actions,
           namespaced: true
         }
        }
      })
    })

    it("sets all accurate data and simulates a submission", async () => {
        
        const wrapper = shallowMount(CreateCategory, { store, localVue });
        // checks if the component name is accurate
        expect(wrapper.vm.$options.name).toMatch('CreateCategory');
    
        expect(wrapper.setData({
            name: 'Health and Lifestyle'
          }));
          
          await wrapper.find('button').trigger('click');
          expect(actions.createCategory).toHaveBeenCalled()
        });
      });
    
    