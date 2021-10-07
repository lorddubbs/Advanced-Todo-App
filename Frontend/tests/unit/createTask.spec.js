import { createLocalVue, shallowMount } from "@vue/test-utils";
import Vuex from 'vuex';
import CreateTask from "@/common/components/forms/CreateTask";
import DatePicker from 'vue2-datepicker';

jest.mock('vue2-datepicker', () => ({DatePicker: jest.fn()}));

const localVue = createLocalVue();
localVue.use(Vuex);


describe("CreateTask", () => {
    
    let actions;
    let store;

    beforeEach(() => {

      actions = {
        createTask: jest.fn()
      }

      store = new Vuex.Store({
        modules: { 
         task: {
           actions,
           namespaced: true
         }
        }
      })
    })

    it("sets all accurate data and simulates a submission", async () => {
        const categoryData = [
            {
                id: 1,
                name: "Laundry",
                created_at: "2021-10-10",
                updated_at: "2021-10-10"
            }
        ]
        const wrapper = shallowMount(CreateTask, { store, localVue,
          propsData: {
            categories: categoryData
          }
        });
        // checks if the component name is accurate
        expect(wrapper.vm.$options.name).toMatch('CreateTask');
  

        // create mock image file
        const thumbnail = {
            size: 1000, 
            type: "image/png",
            name: "logo.png"
        };

        // mock the onchange event for image 
        const event = { 
          target: { 
            files: [thumbnail]
          }
        };

        // check if the file is same as content

        expect(wrapper.vm.getFile(event)).toEqual(thumbnail);
        
        // set input data


        expect(wrapper.setData({
            title: 'Workout Plan',
            category_id: categoryData.id,
            description: 'Lorem Ipsum',
            priority: 'low',
            start_date: '2021-10-10',
            end_date: '2021-10-10',
            access: 1
          }));
          
          await wrapper.find('button').trigger('click');
          expect(actions.createTask).toHaveBeenCalled()
        });
      });
    
    